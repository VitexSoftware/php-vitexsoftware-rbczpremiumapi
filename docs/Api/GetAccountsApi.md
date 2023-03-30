# VitexSoftware\Raiffeisenbank\GetAccountsApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAccounts()**](GetAccountsApi.md#getAccounts) | **GET** /rbcz/premium/mock/accounts |  |


## `getAccounts()`

```php
getAccounts($xIBMClientId, $xRequestId, $pSUIPAddress, $page, $size): object
```



Get list of accounts for given certificate. First page is 1.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\GetAccountsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new \VitexSoftware\Raiffeisenbank\ApiClient()
);
$xIBMClientId = 'xIBMClientId_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$pSUIPAddress = 'pSUIPAddress_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.
$page = 56; // int | Number of the requested page. Default is 1.
$size = 56; // int | Number of items on the page. Default is 15.

try {
    $result = $apiInstance->getAccounts($xIBMClientId, $xRequestId, $pSUIPAddress, $page, $size);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetAccountsApi->getAccounts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xIBMClientId** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **pSUIPAddress** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |
| **page** | **int**| Number of the requested page. Default is 1. | [optional] |
| **size** | **int**| Number of items on the page. Default is 15. | [optional] |

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
