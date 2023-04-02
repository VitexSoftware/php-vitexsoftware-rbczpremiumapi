# VitexSoftware\Raiffeisenbank\GetTransactionListApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getTransactionList()**](GetTransactionListApi.md#getTransactionList) | **GET** /rbcz/premium/mock/accounts/{accountNumber}/{currencyCode}/transactions |  |


## `getTransactionList()`

```php
getTransactionList( $xRequestId, $accountNumber, $currencyCode, $from, $to,  $page): object
```



Get a list of posted transactions (including intraday). In addition, transactions must not be older than **90 days** - see request parameter `from`.  The list is returned as a sequence of pages - see request parameter `page`. The request parameter/flag `lastPage` indicates whether the returned page is the last one or if there are more pages that you can iterate.  The limit _Number of requests per second_ (see your subscription plan) is shared among all consumers. Your app needs to implement some delay when iterating pages. Also it needs to be ready to get HTTP 409 (too many requests).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\GetTransactionListApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$accountNumber = 'accountNumber_example'; // string | Account number for which to get list of transactions in national format without 0 padding.
$currencyCode = 'currencyCode_example'; // string | Currency code of the account in ISO-4217 standard (e.g. czk, eur, usd)
$from = new \DateTime("2013-10-20T19:20:30+01:00"); // \DateTime | Defines date (and optionally time) from which transactions will be requested. If no time is specified then 00:00:00.0 will be used. Example values - 2021-08-01 or 2021-08-01T10:00:00.0Z
$to = new \DateTime("2013-10-20T19:20:30+01:00"); // \DateTime | Defines date (and optionally time) until which transactions will be requested. If no time is specified then 23:59:59.999 will be used. Example values - 2021-08-02 or 2021-08-02T14:00:00.0Z
$page = 56; // int | Page number to be requested. The first page is 1.

try {
    $result = $apiInstance->getTransactionList( $xRequestId, $accountNumber, $currencyCode, $from, $to,  $page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetTransactionListApi->getTransactionList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **accountNumber** | **string**| Account number for which to get list of transactions in national format without 0 padding. | |
| **currencyCode** | **string**| Currency code of the account in ISO-4217 standard (e.g. czk, eur, usd) | |
| **from** | **\DateTime**| Defines date (and optionally time) from which transactions will be requested. If no time is specified then 00:00:00.0 will be used. Example values - 2021-08-01 or 2021-08-01T10:00:00.0Z | |
| **to** | **\DateTime**| Defines date (and optionally time) until which transactions will be requested. If no time is specified then 23:59:59.999 will be used. Example values - 2021-08-02 or 2021-08-02T14:00:00.0Z | |
| **page** | **int**| Page number to be requested. The first page is 1. | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
