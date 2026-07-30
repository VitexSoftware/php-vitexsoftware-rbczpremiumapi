# Raiffeisenbank Premium API client library

![Library Logo](library-logo.svg?raw=true)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
![Packaging: deb](https://img.shields.io/badge/packaging-.deb-red?logo=debian&logoColor=white)


 php client library for rbczpremiumapi 



## Installation & Usage

### Requirements

Should with PHP 8+.

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

Set the `RBAPI_RATE_LIMIT_JSON_FILE` to override default /tmp/rbczpremiumapi_rates.json

Set the `RBAPI_RATE_LIMIT_LOCK_DIR` to override the default directory (system temp dir) used for the per-certificate lock files that serialize concurrent requests.

When the `RBAPI_RATE_WAIT_MODE` is not set, the RateLimitExceededException is throwed. The 'true' value waits for the window to reset, up to `RBAPI_RATE_MAX_WAIT_SECONDS` (see below).

`RateLimitExceededException` extends `ApiException`, so any code that already catches `ApiException` around API calls catches rate-limit errors too, with `getCode() === 429`.

Set `RBAPI_RATE_MAX_WAIT_SECONDS` (default `300`) to cap how long wait mode will ever `sleep()` for. The day-window reset can be up to 24h away; without a cap, wait mode would block the caller for that long. When the required wait exceeds this cap, `RateLimitExceededException` is thrown instead, even in wait mode.

Set `RBAPI_GLOBAL_RATE_LIMIT_PER_SECOND` (or pass `global_rate_limit_per_second` in the client config) to cap requests per second host-wide, across *all* certificates sharing the rate limit store — not just the one making the current request. This is disabled by default (0). It exists because RB's rate-limit response headers only ever report the remaining quota for the certificate that made the request: if the gateway enforces a shared limit above the per-certificate level (e.g. per source IP or per account-holder), many certificates can each still show plenty of per-certificate headroom while collectively exceeding that shared limit — none of them can see it coming from the headers alone. This setting is a client-side, self-tracked cap (counted by the library itself, not derived from RB's headers) rather than a fix for a specific documented RB limit, so pick a conservative value for your deployment.


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

## Rate Limiting

This library implements a rate limiting mechanism in the `VitexSoftware\Raiffeisenbank\RateLimit` namespace. It automatically tracks and respects API rate limits using response headers, and can pause or throw exceptions if limits are exceeded.

- **RateLimiter**: Handles rate limit logic and enforces waiting or error on limit exceed.
- **RateLimitStoreInterface**: Interface for storing rate limit state per client and window (second/day).
- **SqlDialect**: Interface for SQL dialects used in rate limit storage implementations.

`ApiClient::send()` recovers the HTTP response from Guzzle's `RequestException` on 4xx/5xx status codes (Guzzle's default `http_errors` behavior would otherwise throw before the 429 handling ever runs), so a 429 always reaches the rate-limit logic instead of leaking a raw Guzzle exception.

Rate limits are enforced per certificate. Since several independent processes (e.g. one per bank account under the same company certificate) can call the API concurrently using the same certificate, `ApiClient::send()` serializes the whole check-send-update cycle per certificate fingerprint with an exclusive file lock (`RateLimiter::acquireLock()`/`releaseLock()`), preventing concurrent processes from racing past each other's stale rate-limit counters and all landing in the same request window.

Per-certificate enforcement has a blind spot: it can't see a rate limit the gateway enforces above the certificate level (e.g. per source IP or per account-holder), since RB's response headers only ever report the calling certificate's own remaining quota. `RateLimiter::checkGlobalBeforeRequest()` closes that gap with an opt-in, self-tracked host-wide cap (`RBAPI_GLOBAL_RATE_LIMIT_PER_SECOND`, see above) — counted locally by the library across all certificates sharing the store, independent of what any single certificate's headers report.

The rate limiting mechanism ensures compliance with the API's restrictions and helps prevent accidental overuse. See the source code in `lib/RateLimit/` for details and extension options.

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

