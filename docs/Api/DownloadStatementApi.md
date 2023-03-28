# OpenAPI\Client\DownloadStatementApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**downloadStatement()**](DownloadStatementApi.md#downloadStatement) | **POST** /rbcz/premium/mock/accounts/statements/download |  |


## `downloadStatement()`

```php
downloadStatement($x_ibm_client_id, $x_request_id, $accept_language, $request_body, $psu_ip_address): \SplFileObject
```



Download the selected statement.  Returns one of the following `Content-type` header values depending on  the downloaded document type: <code>application/pdf</code>, <code>application/xml</code>, <code>text/mt940</code>, <code>application/json</code> (in case of an error).

### Example

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

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_ibm_client_id** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **x_request_id** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **accept_language** | **string**| The Accept-Language request HTTP header is used to determine document  language. Supported languages are &#x60;cs&#x60; and &#x60;en&#x60;. | |
| **request_body** | [**\OpenAPI\Client\Model\DownloadStatementRequest**](../Model/DownloadStatementRequest.md)|  | |
| **psu_ip_address** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |

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
