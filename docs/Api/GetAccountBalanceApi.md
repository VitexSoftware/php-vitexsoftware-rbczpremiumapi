# VitexSoftware\Raiffeisenbank\GetAccountBalanceApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getBalance()**](GetAccountBalanceApi.md#getBalance) | **GET** /rbcz/premium/api/accounts/{accountNumber}/balance |  |


## `getBalance()`

```php
```



Get balance for given accounts.  The number of requests is limited to 10 per client per second and 5000  per client per day. The consumer must be able to handle HTTP status  429 (too many requests) in case of exceeding these limits.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new \VitexSoftware\Raiffeisenbank\PremiumAPI\GetAccountBalanceApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$accountNumber = 'accountNumber_example'; // string | The number of account without prefix and bankCode

try {
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetAccountBalanceApi->getBalance: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **accountNumber** | **string**| The number of account without prefix and bankCode | |

### Return type

[**\VitexSoftware\Raiffeisenbank\Model\GetBalance200Response**](../Model/GetBalance200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
