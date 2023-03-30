# VitexSoftware\Raiffeisenbank\GetBatchDetailApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getBatchDetail()**](GetBatchDetailApi.md#getBatchDetail) | **GET** /rbcz/premium/mock/payments/batches/{batchFileId} |  |


## `getBatchDetail()`

```php
getBatchDetail($xIBMClientId, $xRequestId, $batchFileId, $pSUIPAddress): object
```



Getting details about state of processing of imported batch file and created batch transactions.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\GetBatchDetailApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new \VitexSoftware\Raiffeisenbank\ApiClient()
);
$xIBMClientId = 'xIBMClientId_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$batchFileId = 56; // int | Batch file id
$pSUIPAddress = 'pSUIPAddress_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.

try {
    $result = $apiInstance->getBatchDetail($xIBMClientId, $xRequestId, $batchFileId, $pSUIPAddress);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetBatchDetailApi->getBatchDetail: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xIBMClientId** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **batchFileId** | **int**| Batch file id | |
| **pSUIPAddress** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |

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
