# OpenAPI\Client\UploadPaymentsApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**importPayments()**](UploadPaymentsApi.md#importPayments) | **POST** /rbcz/premium/mock/payments/batches |  |


## `importPayments()`

```php
importPayments($x_ibm_client_id, $x_request_id, $batch_import_format, $request_body, $psu_ip_address, $batch_name): object
```



Importing batch payments in one of [supported formates](https://www.rb.cz/attachments/direct-banking/ekomunikator-datova-struktura.pdf) - see request parameter `Batch-Import-Format`.  This is API alternative to manual import of batch payments through [Internet Banking](https://www.rb.cz/podnikatele/ucty-a-platebni-styk/prime-bankovnictvi/internetove-bankovnictvi/caste-dotazy/import-hromadnych-plateb).  Imported payments are not immediately processed, they are just loaded into Internet Banking and they still must be authorized/certified in Internet Banking according to client settings of disposable rights and signatures.  Number of transactions in one request is limited to 5.000 (this can change without prior notice). Number of transactions is not checked during the call, it is performed later and possible error is provided in Internet Banking.  Once authorized/certified, uploaded payments will be processed in the Instant payments mode if the following conditions are met&#58;  1) the batch has no more than 50 payments  2) no more than 5 batches per day were uploaded  3) individual payments meet the conditions for Instant payments - see [Instant Payments](https://www.rb.cz/informacni-servis/platebni-styk/tuzemske-platby/okamzite-platby)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\UploadPaymentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_ibm_client_id = 'x_ibm_client_id_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = 'x_request_id_example'; // string | Unique request id provided by consumer application for reference and auditing.
$batch_import_format = 'batch_import_format_example'; // string | Format of imported batch. For CCT format please use option SEPA-XML.
$request_body = 'request_body_example'; // string
$psu_ip_address = 'psu_ip_address_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.
$batch_name = 'batch_name_example'; // string | Batch name, if not present then will be generated in format `ImportApi_<DDMMYYYY>`.  If the name is longer than 50 characters, it will be truncated

try {
    $result = $apiInstance->importPayments($x_ibm_client_id, $x_request_id, $batch_import_format, $request_body, $psu_ip_address, $batch_name);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UploadPaymentsApi->importPayments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_ibm_client_id** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **x_request_id** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **batch_import_format** | **string**| Format of imported batch. For CCT format please use option SEPA-XML. | |
| **request_body** | **string**|  | |
| **psu_ip_address** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |
| **batch_name** | **string**| Batch name, if not present then will be generated in format &#x60;ImportApi_&lt;DDMMYYYY&gt;&#x60;.  If the name is longer than 50 characters, it will be truncated | [optional] |

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
