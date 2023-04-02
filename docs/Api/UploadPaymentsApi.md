# VitexSoftware\Raiffeisenbank\UploadPaymentsApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**importPayments()**](UploadPaymentsApi.md#importPayments) | **POST** /rbcz/premium/api/payments/batches |  |


## `importPayments()`

```php
importPayments( $xRequestId, $batchImportFormat, $requestBody,  $batchName): object
```



Importing batch payments in one of [supported formates](https://www.rb.cz/attachments/direct-banking/ekomunikator-datova-struktura.pdf) - see request parameter `Batch-Import-Format`.  This is API alternative to manual import of batch payments through [Internet Banking](https://www.rb.cz/podnikatele/ucty-a-platebni-styk/prime-bankovnictvi/internetove-bankovnictvi/caste-dotazy/import-hromadnych-plateb).  Imported payments are not immediately processed, they are just loaded into Internet Banking and they still must be authorized/certified in Internet Banking according to client settings of disposable rights and signatures.  Number of transactions in one request is limited to 5.000 (this can change without prior notice). Number of transactions is not checked during the call, it is performed later and possible error is provided in Internet Banking.  The number of requests is limited to 5 per client per second and 5000  per client per day. The consumer must be able to handle HTTP status  429 (too many requests) in case of exceeding these limits.  Once authorized/certified, uploaded payments will be processed in the Instant payments mode if the following conditions are met&#58;  1) the batch has no more than 50 payments  2) no more than 5 batches per day were uploaded  3) individual payments meet the conditions for Instant payments - see [Instant Payments](https://www.rb.cz/informacni-servis/platebni-styk/tuzemske-platby/okamzite-platby)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\UploadPaymentsApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$batchImportFormat = 'batchImportFormat_example'; // string | Format of imported batch. For CCT format please use option SEPA-XML.
$requestBody = 'requestBody_example'; // string
$batchName = 'batchName_example'; // string | Batch name, if not present then will be generated in format `ImportApi_<DDMMYYYY>`.  If the name is longer than 50 characters, it will be truncated

try {
    $result = $apiInstance->importPayments( $xRequestId, $batchImportFormat, $requestBody,  $batchName);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UploadPaymentsApi->importPayments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **batchImportFormat** | **string**| Format of imported batch. For CCT format please use option SEPA-XML. | |
| **requestBody** | **string**|  | |
| **batchName** | **string**| Batch name, if not present then will be generated in format &#x60;ImportApi_&lt;DDMMYYYY&gt;&#x60;.  If the name is longer than 50 characters, it will be truncated | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `text/plain`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
