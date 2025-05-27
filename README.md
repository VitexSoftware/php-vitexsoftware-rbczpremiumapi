# Raiffeisenbank Premium API client library

![Library Logo](library-logo.svg?raw=true)


 php client library for rbczpremiumapi 



## Installation & Usage


### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/VitexSoftware/php-vitexsoftware-rbczpremiumapi.git"
    }
  ],
  "require": {
    "vitexsoftware/php-vitexsoftware-rbczpremiumapi": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/Raiffeisenbank Premium API client library/vendor/autoload.php');
```

## Getting Started


Example environment or contents of [.env](examples/example.env) file for basic library configuration
```
CERT_FILE=examples/test_cert.p12
CERT_PASS=test12345678
XIBMCLIENTID=FbboLD2r1WHDRcuKS4wWUbSRHxlDloWL
API_DEBUG=True
```

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');





$apiInstance = new VitexSoftware\Raiffeisenbank\Api\DownloadStatementApi(
    // If you want use custom http client, pass your client which implements 
    // `GuzzleHttp\ClientInterface`.
    // This is optional, Internal `ApiClient` will be used as default.
    // Else you must call setXIBMClientId($lientID) and $this->setSUIPAddress($clientPubIP) 
    // methods to set API call properly      

    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);


$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$acceptLanguage = 'acceptLanguage_example'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$requestBody = new \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest(); // \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest

try {
    $result = $apiInstance->downloadStatement( $xRequestId, $acceptLanguage, $requestBody, $pSUIPAddress);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DownloadStatementApi->downloadStatement: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://api.rb.cz*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DownloadStatementApi* | [**downloadStatement**](docs/Api/DownloadStatementApi.md#downloadstatement) | **POST** /rbcz/premium/api/accounts/statements/download | 
*GetAccountBalanceApi* | [**getBalance**](docs/Api/GetAccountBalanceApi.md#getbalance) | **GET** /rbcz/premium/api/accounts/{accountNumber}/balance | 
*GetAccountsApi* | [**getAccounts**](docs/Api/GetAccountsApi.md#getaccounts) | **GET** /rbcz/premium/api/accounts | 
*GetBatchDetailApi* | [**getBatchDetail**](docs/Api/GetBatchDetailApi.md#getbatchdetail) | **GET** /rbcz/premium/api/payments/batches/{batchFileId} | 
*GetFxRatesApi* | [**getFxRates**](docs/Api/GetFxRatesApi.md#getfxrates) | **GET** /rbcz/premium/api/fxrates/{currencyCode} | 
*GetFxRatesListApi* | [**getFxRatesList**](docs/Api/GetFxRatesListApi.md#getfxrateslist) | **GET** /rbcz/premium/api/fxrates | 
*GetStatementListApi* | [**getStatements**](docs/Api/GetStatementListApi.md#getstatements) | **POST** /rbcz/premium/api/accounts/statements | 
*GetTransactionListApi* | [**getTransactionList**](docs/Api/GetTransactionListApi.md#gettransactionlist) | **GET** /rbcz/premium/api/accounts/{accountNumber}/{currencyCode}/transactions | 
*UploadPaymentsApi* | [**importPayments**](docs/Api/UploadPaymentsApi.md#importpayments) | **POST** /rbcz/premium/api/payments/batches | 

## Models

- [CurrencyListSimple](docs/Model/CurrencyListSimple.md)
- [DownloadStatementRequest](docs/Model/DownloadStatementRequest.md)
- [ExchangeRate](docs/Model/ExchangeRate.md)
- [ExchangeRateList](docs/Model/ExchangeRateList.md)
- [GetAccounts200Response](docs/Model/GetAccounts200Response.md)
- [GetAccounts200ResponseAccountsInner](docs/Model/GetAccounts200ResponseAccountsInner.md)
- [GetBalance200Response](docs/Model/GetBalance200Response.md)
- [GetBalance200ResponseCurrencyFoldersInner](docs/Model/GetBalance200ResponseCurrencyFoldersInner.md)
- [GetBalance200ResponseCurrencyFoldersInnerBalancesInner](docs/Model/GetBalance200ResponseCurrencyFoldersInnerBalancesInner.md)
- [GetBalance401Response](docs/Model/GetBalance401Response.md)
- [GetBalance403Response](docs/Model/GetBalance403Response.md)
- [GetBalance404Response](docs/Model/GetBalance404Response.md)
- [GetBalance429Response](docs/Model/GetBalance429Response.md)
- [GetBatchDetail200Response](docs/Model/GetBatchDetail200Response.md)
- [GetBatchDetail200ResponseBatchItemsInner](docs/Model/GetBatchDetail200ResponseBatchItemsInner.md)
- [GetBatchDetail200ResponseBatchItemsInnerAccountInfo](docs/Model/GetBatchDetail200ResponseBatchItemsInnerAccountInfo.md)
- [GetBatchDetail400Response](docs/Model/GetBatchDetail400Response.md)
- [GetStatements200Response](docs/Model/GetStatements200Response.md)
- [GetStatements200ResponseStatementsInner](docs/Model/GetStatements200ResponseStatementsInner.md)
- [GetStatements400Response](docs/Model/GetStatements400Response.md)
- [GetStatementsRequest](docs/Model/GetStatementsRequest.md)
- [GetTransactionList200Response](docs/Model/GetTransactionList200Response.md)
- [GetTransactionList200ResponseTransactionsInner](docs/Model/GetTransactionList200ResponseTransactionsInner.md)
- [GetTransactionList200ResponseTransactionsInnerAmount](docs/Model/GetTransactionList200ResponseTransactionsInnerAmount.md)
- [GetTransactionList200ResponseTransactionsInnerBankTransactionCode](docs/Model/GetTransactionList200ResponseTransactionsInnerBankTransactionCode.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetails](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetails.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetails](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetails.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsInstructedAmount](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsInstructedAmount.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsReferences](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsReferences.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedParties](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedParties.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterParty](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterParty.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyAccount](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyAccount.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyOrganisationIdentification](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyOrganisationIdentification.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyOrganisationIdentificationPostalAddress](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyOrganisationIdentificationPostalAddress.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyPostalAddress](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesCounterPartyPostalAddress.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesIntermediaryInstitution](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesIntermediaryInstitution.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesIntermediaryInstitutionPostalAddress](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesIntermediaryInstitutionPostalAddress.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesUltimateCounterParty](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRelatedPartiesUltimateCounterParty.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRemittanceInformation](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRemittanceInformation.md)
- [GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRemittanceInformationCreditorReferenceInformation](docs/Model/GetTransactionList200ResponseTransactionsInnerEntryDetailsTransactionDetailsRemittanceInformationCreditorReferenceInformation.md)
- [GetTransactionList400Response](docs/Model/GetTransactionList400Response.md)
- [ImportPayments200Response](docs/Model/ImportPayments200Response.md)
- [ImportPayments400Response](docs/Model/ImportPayments400Response.md)
- [ImportPayments413Response](docs/Model/ImportPayments413Response.md)
- [ImportPayments415Response](docs/Model/ImportPayments415Response.md)

## Authorization
All endpoints do not require authorization.
## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author

info@vitexsoftware.cz

## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.1.20240910`
    - Package version: `1.3.1`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`


Library is Used by: 
 * https://github.com/VitexSoftware/abraflexi-raiffeisenbank
 * https://github.com/Spoje-NET/raiffeisenbank-statement-downloader
 * https://github.com/Spoje-NET/pohoda-raiffeisenbank
