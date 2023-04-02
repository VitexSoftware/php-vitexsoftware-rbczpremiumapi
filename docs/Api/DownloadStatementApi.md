# VitexSoftware\Raiffeisenbank\DownloadStatementApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**downloadStatement()**](DownloadStatementApi.md#downloadStatement) | **POST** /rbcz/premium/mock/accounts/statements/download |  |


## `downloadStatement()`

```php
```



Download the selected statement.  Returns one of the following `Content-type` header values depending on  the downloaded document type: <code>application/pdf</code>, <code>application/xml</code>, <code>text/mt940</code>, <code>application/json</code> (in case of an error).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\DownloadStatementApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$acceptLanguage = 'acceptLanguage_example'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$requestBody = new \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest(); // \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest

try {
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DownloadStatementApi->downloadStatement: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **acceptLanguage** | **string**| The Accept-Language request HTTP header is used to determine document  language. Supported languages are &#x60;cs&#x60; and &#x60;en&#x60;. | |
| **requestBody** | [**\VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest**](../Model/DownloadStatementRequest.md)|  | |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `*/*`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
