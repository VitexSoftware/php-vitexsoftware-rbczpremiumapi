# OpenAPI\Client\GetTransactionListApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getTransactionList()**](GetTransactionListApi.md#getTransactionList) | **GET** /rbcz/premium/mock/accounts/{accountNumber}/{currencyCode}/transactions |  |


## `getTransactionList()`

```php
getTransactionList($x_ibm_client_id, $x_request_id, $account_number, $currency_code, $from, $to, $psu_ip_address, $page): object
```



Get a list of posted transactions (including intraday). In addition, transactions must not be older than **90 days** - see request parameter `from`.  The list is returned as a sequence of pages - see request parameter `page`. The request parameter/flag `lastPage` indicates whether the returned page is the last one or if there are more pages that you can iterate.  The limit _Number of requests per second_ (see your subscription plan) is shared among all consumers. Your app needs to implement some delay when iterating pages. Also it needs to be ready to get HTTP 409 (too many requests).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GetTransactionListApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_ibm_client_id = 'x_ibm_client_id_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = 'x_request_id_example'; // string | Unique request id provided by consumer application for reference and auditing.
$account_number = 'account_number_example'; // string | Account number for which to get list of transactions in national format without 0 padding.
$currency_code = 'currency_code_example'; // string | Currency code of the account in ISO-4217 standard (e.g. czk, eur, usd)
$from = new \DateTime("2013-10-20T19:20:30+01:00"); // \DateTime | Defines date (and optionally time) from which transactions will be requested. If no time is specified then 00:00:00.0 will be used. Example values - 2021-08-01 or 2021-08-01T10:00:00.0Z
$to = new \DateTime("2013-10-20T19:20:30+01:00"); // \DateTime | Defines date (and optionally time) until which transactions will be requested. If no time is specified then 23:59:59.999 will be used. Example values - 2021-08-02 or 2021-08-02T14:00:00.0Z
$psu_ip_address = 'psu_ip_address_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.
$page = 56; // int | Page number to be requested. The first page is 1.

try {
    $result = $apiInstance->getTransactionList($x_ibm_client_id, $x_request_id, $account_number, $currency_code, $from, $to, $psu_ip_address, $page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetTransactionListApi->getTransactionList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_ibm_client_id** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **x_request_id** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **account_number** | **string**| Account number for which to get list of transactions in national format without 0 padding. | |
| **currency_code** | **string**| Currency code of the account in ISO-4217 standard (e.g. czk, eur, usd) | |
| **from** | **\DateTime**| Defines date (and optionally time) from which transactions will be requested. If no time is specified then 00:00:00.0 will be used. Example values - 2021-08-01 or 2021-08-01T10:00:00.0Z | |
| **to** | **\DateTime**| Defines date (and optionally time) until which transactions will be requested. If no time is specified then 23:59:59.999 will be used. Example values - 2021-08-02 or 2021-08-02T14:00:00.0Z | |
| **psu_ip_address** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |
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
