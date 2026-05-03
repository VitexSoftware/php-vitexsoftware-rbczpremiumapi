# VitexSoftware\Raiffeisenbank\GetAccountBalanceApi

All URIs are relative to https://api.rb.cz.

Method | HTTP request | Description
------------- | ------------- | -------------
[**getBalance()**](GetAccountBalanceApi.md#getBalance) | **GET** /rbcz/premium/api/accounts/{accountNumber}/balance | 


## `getBalance()`

```php
```



Get balance for given accounts.  Balance can be of one of the following types in this table:  | Abbreviation  | Balance type      | Description                                                                                        |  | ------------- | ----------------- | -------------------------------------------------------------------------------------------------- | | CLAV          | Available balance | Available balance on the account in the time of the response to the request with credit limit      | | CLBD          | Booking balance   | Actual accounting balance on the account                                                           | | CLAB          | Actual balance    | Available balance on the account in the time of the response to the request without credit limit   | | BLCK          | Blocked balance   | Sum of blocked amounts on the account                                                              |

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new VitexSoftware\Raiffeisenbank\Api\GetAccountBalanceApi(
    // If you want use custom http client, pass your client which implements `Psr\Http\Client\ClientInterface`.
    // This is optional, `Psr18ClientDiscovery` will be used to find http client. For instance `GuzzleHttp\Client` implements that interface
    new GuzzleHttp\Client()
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

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. |
 **accountNumber** | **string**| The number of account without prefix and bankCode |

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
