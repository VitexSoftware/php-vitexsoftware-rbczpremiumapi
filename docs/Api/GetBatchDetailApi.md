# VitexSoftware\Raiffeisenbank\GetBatchDetailApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getBatchDetail()**](GetBatchDetailApi.md#getBatchDetail) | **GET** /rbcz/premium/api/payments/batches/{batchFileId} |  |


## `getBatchDetail()`

```php
```



Getting details about state of processing of imported batch file and created batch transactions.  The number of requests is limited to 10 per client per second and 5000  per client per day. The consumer must be able to handle HTTP status  429 (too many requests) in case of exceeding these limits.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\GetBatchDetailApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$batchFileId = 56; // int | Batch file id

try {
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetBatchDetailApi->getBatchDetail: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **batchFileId** | **int**| Batch file id | |

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
