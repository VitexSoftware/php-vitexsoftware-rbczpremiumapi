# VitexSoftware\Raiffeisenbank\DownloadStatementApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**downloadStatement()**](DownloadStatementApi.md#downloadStatement) | **POST** /rbcz/premium/mock/accounts/statements/download |  |


## `downloadStatement()`

```php
downloadStatement($xIBMClientId, $xRequestId, $acceptLanguage, $requestBody, $pSUIPAddress): \SplFileObject
```



Download the selected statement.  Returns one of the following `Content-type` header values depending on  the downloaded document type: <code>application/pdf</code>, <code>application/xml</code>, <code>text/mt940</code>, <code>application/json</code> (in case of an error).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\DownloadStatementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new \VitexSoftware\Raiffeisenbank\ApiClient()
);
$xIBMClientId = 'xIBMClientId_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$acceptLanguage = 'acceptLanguage_example'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$requestBody = new \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest(); // \VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest
$pSUIPAddress = 'pSUIPAddress_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.

try {
    $result = $apiInstance->downloadStatement($xIBMClientId, $xRequestId, $acceptLanguage, $requestBody, $pSUIPAddress);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DownloadStatementApi->downloadStatement: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xIBMClientId** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **acceptLanguage** | **string**| The Accept-Language request HTTP header is used to determine document  language. Supported languages are &#x60;cs&#x60; and &#x60;en&#x60;. | |
| **requestBody** | [**\VitexSoftware\Raiffeisenbank\Model\DownloadStatementRequest**](../Model/DownloadStatementRequest.md)|  | |
| **pSUIPAddress** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |

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
