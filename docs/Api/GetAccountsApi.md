# VitexSoftware\Raiffeisenbank\GetAccountsApi

All URIs are relative to https://api.rb.cz.

Method | HTTP request | Description
------------- | ------------- | -------------
[**getAccounts()**](GetAccountsApi.md#getAccounts) | **GET** /rbcz/premium/api/accounts | 


## `getAccounts()`

```php
getAccounts( $xRequestId,  $page, $size): \VitexSoftware\Raiffeisenbank\Model\GetAccounts200Response
```



Get list of accounts for given certificate. First page is 1.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\GetAccountsApi(
    // If you want use custom http client, pass your client which implements `Psr\Http\Client\ClientInterface`.
    // This is optional, `Psr18ClientDiscovery` will be used to find http client. For instance `GuzzleHttp\Client` implements that interface
    new GuzzleHttp\Client()
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$page = 56; // int | Number of the requested page. Default is 1.
$size = 56; // int | Number of items on the page. Default is 15.

try {
    $result = $apiInstance->getAccounts( $xRequestId,  $page, $size);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetAccountsApi->getAccounts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. |
 **page** | **int**| Number of the requested page. Default is 1. | [optional]
 **size** | **int**| Number of items on the page. Default is 15. | [optional]

### Return type

[**\VitexSoftware\Raiffeisenbank\Model\GetAccounts200Response**](../Model/GetAccounts200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
