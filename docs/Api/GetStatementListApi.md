# VitexSoftware\Raiffeisenbank\GetStatementListApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getStatements()**](GetStatementListApi.md#getStatements) | **POST** /rbcz/premium/api/accounts/statements |  |


## `getStatements()`

```php
getStatements( $xRequestId, $requestBody,  $page, $size): \VitexSoftware\Raiffeisenbank\Model\GetStatements200Response
```



Lists statements for all available accounts for which the client has appropriate access rights.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new \VitexSoftware\Raiffeisenbank\PremiumAPI\GetStatementListApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$requestBody = new \VitexSoftware\Raiffeisenbank\Model\GetStatementsRequest(); // \VitexSoftware\Raiffeisenbank\Model\GetStatementsRequest
$page = 56; // int | Number of the requested page. Default is 1.
$size = 56; // int | Number of items on the page. Default is 15.

try {
    $result = $apiInstance->getStatements( $xRequestId, $requestBody,  $page, $size);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetStatementListApi->getStatements: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **requestBody** | [**\VitexSoftware\Raiffeisenbank\Model\GetStatementsRequest**](../Model/GetStatementsRequest.md)|  | |
| **page** | **int**| Number of the requested page. Default is 1. | [optional] |
| **size** | **int**| Number of items on the page. Default is 15. | [optional] |

### Return type

[**\VitexSoftware\Raiffeisenbank\Model\GetStatements200Response**](../Model/GetStatements200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
