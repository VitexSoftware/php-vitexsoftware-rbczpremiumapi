<?php

declare(strict_types=1);

/**
 * This file is part of the MultiFlexi package
 *
 * https://github.com/VitexSoftware/php-vitexsoftware-rbczpremiumapi
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VitexSoftware\Raiffeisenbank;

/**
 * Handle bank transactions.
 *
 * @author vitex
 *
 * @no-named-arguments
 */
class Transactor extends ApiClient
{
    /**
     * Transaction Handler.
     *
     * @param array $options
     */
    public function __construct(string $bankAccount, $options = [])
    {
        parent::__construct($bankAccount, $options);
    }

    /**
     * Obtain Transactions from RB.
     *
     * @return array
     */
    public function getTransactions()
    {
        $apiInstance = new \VitexSoftware\Raiffeisenbank\PremiumAPI\GetTransactionListApi();
        $page = 1;
        $transactions = [];
        $this->addStatusMessage(sprintf(_('Request transactions from %s to %s'), $this->since->format(self::$dateTimeFormat), $this->until->format(self::$dateTimeFormat)), 'debug');

        try {
            do {
                $result = $apiInstance->getTransactionList($this->getxRequestId(), $this->getDataValue('account'), $this->getCurrencyCode(), $this->since->format(self::$dateTimeFormat), $this->until->format(self::$dateTimeFormat), $page);

                if (empty($result)) {
                    $this->addStatusMessage(sprintf(_('No transactions from %s to %s'), $this->since->format(self::$dateTimeFormat), $this->until->format(self::$dateTimeFormat)));
                    $result['lastPage'] = true;
                }

                if (\array_key_exists('transactions', $result)) {
                    $transactions = array_merge($transactions, $result['transactions']);
                }

                if (\array_key_exists('lastPage', $result) === false) {
                    $result['lastPage'] = true;
                }
            } while ($result['lastPage'] === false);
        } catch (Exception $e) {
            echo 'Exception when calling GetTransactionListApi->getTransactionList: ', $e->getMessage(), \PHP_EOL;
        }

        return $transactions;
    }

    /**
     * Import process itself.
     */
    public function import(): void
    {
        //        $allMoves = $this->getColumnsFromPohoda('id', ['limit' => 0, 'banka' => $this->bank]);
        $allTransactions = $this->getTransactions();
        $this->addStatusMessage(\count($allTransactions).' transactions obtained via API', 'debug');
        $success = 0;

        foreach ($allTransactions as $transaction) {
            // $this->dataReset();
            $this->takeTransactionData($transaction);
            $success = $this->insertTransactionToPohoda($success);
            $this->reset();
        }

        $this->addStatusMessage('Import done. '.$success.' of '.\count($allTransactions).' imported');
    }

    /**
     * Use Transaction data for Bank record.
     *
     * @param array $transactionData
     */
    public function takeTransactionData($transactionData): void
    {
        //        $this->setMyKey(\Pohoda\RO::code('RB' . $transactionData->entryReference));
        $moveTrans = [
            'DBIT' => 'expense',
            'CRDT' => 'receipt',
        ];
        $this->setDataValue('bankType', $moveTrans[$transactionData->creditDebitIndication]);
        $this->setDataValue('account', \Ease\Shared::cfg('POHODA_BANK_IDS')); // KB
        $this->setDataValue('datePayment', (new \DateTime($transactionData->valueDate))->format('Y-m-d'));
        $this->setDataValue('intNote', _('Automatic Import').': '.\Ease\Shared::appName().' '.\Ease\Shared::appVersion().' '.$transactionData->entryReference);
        $this->setDataValue('statementNumber', ['statementNumber' => $transactionData->bankTransactionCode->code]);
        $counterAccount = $transactionData->entryDetails->transactionDetails->relatedParties->counterParty;

        // $bankRecord = [
        // //    "MOSS" => ['ids' => 'AB'],
        //    'account' => 'KB',
        // //    "accounting",
        // //    "accountingPeriodMOSS",
        // //    "activity" => 'testing',
        //    'bankType' => 'receipt',
        // //    "centre",
        // //    "classificationKVDPH",
        // //    "classificationVAT",
        //    "contract" => 'n/a',
        //    "datePayment" => date('Y-m-d'),
        //    "dateStatement" => date('Y-m-d'),
        // //    "evidentiaryResourcesMOSS",
        //    "intNote" => 'Import works well',
        // //    "myIdentity",
        //    "note" => 'Automated import',
        //    'partnerIdentity' => ['address' => ['street' => 'dlouha'], 'shipToAddress' => ['street' => 'kratka']],
        //    "paymentAccount" => ['accountNo' => '1234', 'bankCode' => '5500'],
        //    'statementNumber' => [
        //        'statementNumber' => (string) time(),
        //    //'numberMovement' => (string) time()
        //    ],
        // //    "symConst" => 'XX',
        // // ?"symPar",
        //    "symSpec" => '23',
        //    "symVar" => (string) time(),
        //    "text" => 'Testing income ' . time(),
        //    'homeCurrency' => ['priceNone' => '1001']
        // ];
        //        $this->setDataValue('cisDosle', $transactionData->entryReference);
        if (property_exists($transactionData->entryDetails->transactionDetails->remittanceInformation, 'creditorReferenceInformation')) {
            if (property_exists($transactionData->entryDetails->transactionDetails->remittanceInformation->creditorReferenceInformation, 'variable')) {
                $this->setDataValue('symVar', $transactionData->entryDetails->transactionDetails->remittanceInformation->creditorReferenceInformation->variable);
            }
            //            if (property_exists($transactionData->entryDetails->transactionDetails->remittanceInformation->creditorReferenceInformation, 'constant')) {
            //                $conSym = $transactionData->entryDetails->transactionDetails->remittanceInformation->creditorReferenceInformation->constant;
            //                if (intval($conSym)) {
            //                    $conSym = sprintf('%04d', $conSym);
            //                    $this->ensureKSExists($conSym);
            //                    $this->setDataValue('konSym', \Pohoda\RO::code($conSym));
            //                }
            //            }
        }

        //        $this->setDataValue('datVyst', $transactionData->bookingDate);
        // $this->setDataValue('duzpPuv', $transactionData->valueDate);
        if (property_exists($transactionData->entryDetails->transactionDetails->remittanceInformation, 'originatorMessage')) {
            $this->setDataValue('text', $transactionData->entryDetails->transactionDetails->remittanceInformation->originatorMessage);
        }

        $this->setDataValue('note', 'Import Job '.\Ease\Shared::cfg('JOB_ID', 'n/a'));

        if (property_exists($transactionData->entryDetails->transactionDetails->relatedParties, 'counterParty')) {
            if (property_exists($transactionData->entryDetails->transactionDetails->relatedParties->counterParty, 'name')) {
                // TODO                $this->setDataValue('nazFirmy', $transactionData->entryDetails->transactionDetails->relatedParties->counterParty->name);
            }

            $counterAccountNumber = $counterAccount->account->accountNumber;

            if (property_exists($counterAccount->account, 'accountNumberPrefix')) {
                $accountNumber = $counterAccount->account->accountNumberPrefix.'-'.$counterAccountNumber;
            } else {
                $accountNumber = $counterAccountNumber;
            }

            $this->setDataValue('paymentAccount', ['accountNo' => $accountNumber, 'bankCode' => $counterAccount->organisationIdentification->bankCode]);

            $amount = (string) abs($transactionData->amount->value);

            if ($transactionData->amount->currency === 'CZK') {
                $this->setDataValue('homeCurrency', ['priceNone' => $amount]);
            } else {
                $this->setDataValue('foreginCurrency', ['priceNone' => $amount]); // TODO: Not tested
            }
        }
    }

    /**
     * Prepare processing interval.
     *
     * @throws \Exception
     */
    public function setScope(string $scope): void
    {
        switch ($scope) {
            case 'today':
                $this->since = (new \DateTime())->setTime(0, 0);
                $this->until = (new \DateTime())->setTime(23, 59);

                break;
            case 'yesterday':
                $this->since = (new \DateTime('yesterday'))->setTime(0, 0);
                $this->until = (new \DateTime('yesterday'))->setTime(23, 59, 59, 999);

                break;
            case 'auto':
                $this->since = (new \DateTime('89 days ago'))->setTime(0, 0);
                $this->until = new \DateTime();

                break;

            default:
                if (strstr($scope, '>')) {
                    [$begin, $end] = explode('>', $scope);
                    $this->since = new \DateTime($begin);
                    $this->until = new \DateTime($end);
                } else {
                    if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $scope)) {
                        $this->since = (new \DateTime($scope))->setTime(0, 0);
                        $this->until = (new \DateTime($scope))->setTime(23, 59, 59, 999);

                        break;
                    }

                    throw new \InvalidArgumentException('Unknown scope '.$scope);
                }

                break;
        }

        if ($scope !== 'auto' && $scope !== 'today' && $scope !== 'yesterday') {
            $this->since = $this->since->setTime(0, 0);
            $this->until = $this->until->setTime(0, 0);
        }
    }
}
