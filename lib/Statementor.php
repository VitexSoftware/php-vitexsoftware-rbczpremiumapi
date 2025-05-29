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
 * Description of Statementor.
 *
 * @author vitex
 */
class Statementor extends \Ease\Sand
{
    use \Ease\Logger\Logging;
    public \DateTime $since;
    public \DateTime $until;

    /**
     * DateTime Formating eg. 2021-08-01T10:00:00.0Z.
     */
    public static string $dateTimeFormat = 'Y-m-d\\TH:i:s.0\\Z';

    /**
     * DateTime Formating eg. 2021-08-01T10:00:00.0Z.
     */
    public static string $dateFormat = 'Y-m-d';
    private string $accountNumber = '';
    private string $statementLine = 'MAIN';

    public function __construct(string $accountNumber = '', string $scope = '')
    {
        if ($accountNumber) {
            $this->setAccountNumber($accountNumber);
        }

        if ($scope) {
            $this->setScope($scope);
        }
    }

    /**
     * Set AccountNumber for further operations.
     *
     * @param string $accountNumber
     */
    public function setAccountNumber($accountNumber): self
    {
        $this->accountNumber = $accountNumber;
        $this->setObjectName($accountNumber.'@'.\get_class($this));

        return $this;
    }

    /**
     * Set "Statement Line".
     *
     * @param string $line MAIN or ADDITINAL
     *
     * @throws \InvalidArgumentException
     */
    public function setStatementLine(string $line): self
    {
        switch ($line) {
            case 'MAIN':
            case 'ADDITIONAL':
                $this->statementLine = $line;

                break;

            default:
                throw new \InvalidArgumentException('Wrong statement line: '.$line);
        }

        return $this;
    }

    /**
     * Obtain Statements from RB.
     *
     * @param string $currencyCode  CZK,USD etc
     * @param string $statementLine default statement line override
     */
    public function getStatements($currencyCode = 'CZK', string $statementLine = ''): array
    {
        $statementLineFinal = empty($statementLine) ? $this->statementLine : $statementLine;
        $apiInstance = new PremiumAPI\GetStatementListApi();
        $page = 0;
        $statements = [];
        $this->addStatusMessage(sprintf(_('Request statements from %s to %s'), $this->since->format(self::$dateFormat), $this->until->format(self::$dateFormat)), 'debug');

        try {
            $stop = true;

            do {
                $requestBody = new \VitexSoftware\Raiffeisenbank\Model\GetStatementsRequest([
                    'accountNumber' => $this->accountNumber,
                    'page' => ++$page,
                    'size' => 60,
                    'currency' => $currencyCode,
                    'statementLine' => $statementLineFinal,
                    'dateFrom' => $this->since->format(self::$dateFormat),
                    'dateTo' => $this->until->format(self::$dateFormat)]);

                $result = $apiInstance->getStatements(\VitexSoftware\Raiffeisenbank\ApiClient::getxRequestId(), $requestBody, $page);

                $pageStatements = $result->getStatements();

                if (empty($pageStatements)) {
                    $this->addStatusMessage(sprintf(_('No Statements from %s to %s'), $this->since->format(self::$dateFormat), $this->until->format(self::$dateFormat)));
                    $stop = true;
                } else {
                    foreach ($pageStatements as $statement) {
                        if ($statement instanceof \VitexSoftware\Raiffeisenbank\Model\GetStatements200ResponseStatementsInner) {
                            $statements[] = [
                                'statementId' => $statement->getStatementId(),
                                'accountId' => $statement->getAccountId(),
                                'statementNumber' => $statement->getStatementNumber(),
                                'dateFrom' => $statement->getDateFrom()->format(self::$dateFormat),
                                'dateTo' => $statement->getDateTo()->format(self::$dateFormat),
                                'currency' => $statement->getCurrency(),
                                'statementFormats' => $statement->getStatementFormats(),
                            ];
                        } else {
                            $this->addStatusMessage('Invalid statement object type', 'error');
                        }
                    }

                    $stop = $result->getLast() ?? true; // Assuming `getLast()` exists to indicate the last page
                }

                if ($stop === false) {
                    sleep(1);
                }
            } while ($stop === false);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            preg_match('/cURL error ([0-9]+)/', $errorMessage, $matches);

            if (\array_key_exists(1, $matches)) {
                $errorCode = $matches[1];
            } elseif (preg_match('/\[([0-9]+)\]/', $errorMessage, $matches)) {
                $errorCode = $matches[1];
            } else {
                $errorCode = 2;
            }

            $this->addStatusMessage('Exception when calling GetStatementsRequest: '.$errorMessage, 'error', $apiInstance);

            $this->exitCode = (int) $errorCode;
        }

        return $statements;
    }

    /**
     * Prepare processing interval.
     *
     * @param mixed $scope
     *
     * @throws \Exception
     */
    public function setScope(string $scope): \DatePeriod
    {
        switch ($scope) {
            case 'yesterday':
                $this->since = (new \DateTime('yesterday'))->setTime(0, 0);
                $this->until = (new \DateTime('yesterday'))->setTime(23, 59);

                break;
            case 'current_month':
                $this->since = new \DateTime('first day of this month');
                $this->until = new \DateTime();

                break;
            case 'last_month':
                $this->since = new \DateTime('first day of last month');
                $this->until = new \DateTime('last day of last month');

                break;
            case 'last_week':
                $this->since = new \DateTime('first day of last week');
                $this->until = new \DateTime('last day of last week');

                break;
            case 'last_two_months':
                $this->since = (new \DateTime('first day of last month'))->modify('-1 month');
                $this->until = (new \DateTime('last day of last month'));

                break;
            case 'previous_month':
                $this->since = new \DateTime('first day of -2 month');
                $this->until = new \DateTime('last day of -2 month');

                break;
            case 'two_months_ago':
                $this->since = new \DateTime('first day of -3 month');
                $this->until = new \DateTime('last day of -3 month');

                break;
            case 'this_year':
                $this->since = new \DateTime('first day of January '.date('Y'));
                $this->until = new \DateTime('last day of December'.date('Y'));

                break;
            case 'January':  // 1
            case 'February': // 2
            case 'March':    // 3
            case 'April':    // 4
            case 'May':      // 5
            case 'June':     // 6
            case 'July':     // 7
            case 'August':   // 8
            case 'September':// 9
            case 'October':  // 10
            case 'November': // 11
            case 'December': // 12
                $this->since = new \DateTime('first day of '.$scope.' '.date('Y'));
                $this->until = new \DateTime('last day of '.$scope.' '.date('Y'));

                break;
            case 'auto':
                $latestRecord = $this->getColumnsFromPohoda(['id', 'lastUpdate'], ['limit' => 1, 'order' => 'lastUpdate@A', 'source' => $this->sourceString(), 'banka' => $this->bank]);

                if (\array_key_exists(0, $latestRecord) && \array_key_exists('lastUpdate', $latestRecord[0])) {
                    $this->since = $latestRecord[0]['lastUpdate'];
                } else {
                    $this->addStatusMessage('Previous record for "auto since" not found. Defaulting to today\'s 00:00', 'warning');
                    $this->since = (new \DateTime())->setTime(0, 0);
                }

                $this->until = new \DateTime(); // Now

                break;

            default:
                if (strstr($scope, '>')) {
                    [$begin, $end] = explode('>', $scope);
                    $this->since = new \DateTime($begin);
                    $this->until = new \DateTime($end);
                } else {
                    if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $scope)) {
                        $this->since = new \DateTime($scope);
                        $this->until = (new \DateTime($scope))->setTime(23, 59, 59, 999);
                    }

                    throw new \InvalidArgumentException('Unknown scope '.$scope);
                }

                break;
        }

        if ($scope !== 'auto' && $scope !== 'today' && $scope !== 'yesterday') {
            $this->since = $this->since->setTime(0, 0);
            $this->until = $this->until->setTime(23, 59, 59, 999);
        }

        return new \DatePeriod($this->since, new \DateInterval('P1D'), $this->until);
    }

    /**
     * Save Statement PDF files.
     *
     * @param array<mixed> $statements - produced by getStatements() function
     * @param string       $format     pdf|xml
     */
    public function download(string $saveTo, array $statements, string $format = 'pdf', string $currencyCode = 'CZK'): array
    {
        $saved = [];
        $apiInstance = new PremiumAPI\DownloadStatementApi();
        $success = 0;

        foreach ($statements as $statement) {
            $statementFilename = str_replace('/', '_', $statement['statementNumber']).'_'.
                    $this->accountNumber.'_'.
                    $statement['accountId'].'_'.
                    $statement['currency'].'_'.$statement['dateFrom'].'.'.$format;
            $requestBody = new \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest([
                'accountNumber' => $this->accountNumber,
                'currency' => $currencyCode,
                'statementId' => $statement['statementId'],
                'statementFormat' => $format]);
            $pdfStatementRaw = $apiInstance->downloadStatement(ApiClient::getxRequestId(), 'cs', $requestBody);
            sleep(1);

            if (file_put_contents($saveTo.'/'.$statementFilename, $pdfStatementRaw->fread($pdfStatementRaw->getSize()))) {
                $saved[$statementFilename] = $saveTo.'/'.$statementFilename;
                $this->addStatusMessage($statementFilename.' saved', 'success');
                unset($pdfStatementRaw);
                ++$success;
            }
        }

        $this->addStatusMessage('Download done. '.$success.' of '.\count($statements).' saved');

        return $saved;
    }

    /**
     * Since time getter.
     */
    public function getSince(): \DateTime
    {
        return $this->since;
    }

    /**
     * Until time getter.
     */
    public function getUntil(): \DateTime
    {
        return $this->until;
    }
}
