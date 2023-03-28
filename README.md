# raiffeisenbank_client

Sandbox environment.
Transaction overview (also for saving accounts). Payments import. Accounts list. Account balance.

Before making a call to Premium API, you need to register your app at our _Developer portal_. At _Developer Portal_ you obtain ClientID that your app must send in the request as `X-IBM-Client-Id`. These are your keys that grant your app access to the API. However, this is not enough, for a successful call your app needs to use mTLS. Thus, you not only need _https_ but also a client certificate issued by us. Each bank client/user can issue several certificates. Each certificate can permit different sets of operations (http methods) on different bank accounts. All this must be configured in Internet Banking first by each bank client/user (bank clients need to look under _Settings_ and do not forget to download the certificate at the last step). The certificate is downloaded in **PKCS#12** format as **\\*.p12** file and protected by a password chosen by the bank client/user. Yes, your app needs the password as well to get use of the **\\*p12** file for establishing mTLS connection to the bank. 

Client certificates issued in Internet Banking for bank clients/users have limited validity (e.g. **5 years**). However, **each year** certificates are automatically blocked and bank client/user must unblock them in Internet Banking. It is possible to do it in advance and prolong the time before the certificate is blocked. Your app should be prepared for these scenarios and it should communicate such cases to your user in advance to provide seamless service and high user-experience of your app.

For testing purposes please download and use our <a href=\"assets/test_cert.p12\" download> test client certificate</a>. The certificate password is <i>test12345678</i>.

**Note**: Be aware, that in certain error situations, API can return different error structure along with broader set of http status codes, than the one defined below



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
      "url": "https://github.com/VitexSoftware/libpython-semaphore-client.git"
    }
  ],
  "require": {
    "VitexSoftware/libpython-semaphore-client": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/raiffeisenbank_client/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DownloadStatementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_ibm_client_id = 'x_ibm_client_id_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = 'x_request_id_example'; // string | Unique request id provided by consumer application for reference and auditing.
$accept_language = 'accept_language_example'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$request_body = new \OpenAPI\Client\Model\DownloadStatementRequest(); // \OpenAPI\Client\Model\DownloadStatementRequest
$psu_ip_address = 'psu_ip_address_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.

try {
    $result = $apiInstance->downloadStatement($x_ibm_client_id, $x_request_id, $accept_language, $request_body, $psu_ip_address);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DownloadStatementApi->downloadStatement: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://api.rb.cz*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DownloadStatementApi* | [**downloadStatement**](docs/Api/DownloadStatementApi.md#downloadstatement) | **POST** /rbcz/premium/mock/accounts/statements/download | 
*GetAccountBalanceApi* | [**getBalance**](docs/Api/GetAccountBalanceApi.md#getbalance) | **GET** /rbcz/premium/mock/accounts/{accountNumber}/balance | 
*GetAccountsApi* | [**getAccounts**](docs/Api/GetAccountsApi.md#getaccounts) | **GET** /rbcz/premium/mock/accounts | 
*GetBatchDetailApi* | [**getBatchDetail**](docs/Api/GetBatchDetailApi.md#getbatchdetail) | **GET** /rbcz/premium/mock/payments/batches/{batchFileId} | 
*GetStatementListApi* | [**getStatements**](docs/Api/GetStatementListApi.md#getstatements) | **POST** /rbcz/premium/mock/accounts/statements | 
*GetTransactionListApi* | [**getTransactionList**](docs/Api/GetTransactionListApi.md#gettransactionlist) | **GET** /rbcz/premium/mock/accounts/{accountNumber}/{currencyCode}/transactions | 
*UploadPaymentsApi* | [**importPayments**](docs/Api/UploadPaymentsApi.md#importpayments) | **POST** /rbcz/premium/mock/payments/batches | 

## Models

- [DownloadStatementRequest](docs/Model/DownloadStatementRequest.md)
- [GetBalance200Response](docs/Model/GetBalance200Response.md)
- [GetBalance200ResponseCurrencyFoldersInner](docs/Model/GetBalance200ResponseCurrencyFoldersInner.md)
- [GetBalance200ResponseCurrencyFoldersInnerBalancesInner](docs/Model/GetBalance200ResponseCurrencyFoldersInnerBalancesInner.md)
- [GetBalance401Response](docs/Model/GetBalance401Response.md)
- [GetBalance403Response](docs/Model/GetBalance403Response.md)
- [GetBalance404Response](docs/Model/GetBalance404Response.md)
- [GetBalance429Response](docs/Model/GetBalance429Response.md)
- [GetStatementsRequest](docs/Model/GetStatementsRequest.md)
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



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.1.20230222`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
