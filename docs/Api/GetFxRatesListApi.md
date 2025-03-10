# VitexSoftware\Raiffeisenbank\GetFxRatesListApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getFxRatesList()**](GetFxRatesListApi.md#getFxRatesList) | **GET** /rbcz/premium/api/fxrates |  |


## `getFxRatesList()`

```php
getFxRatesList( $xRequestId,  $date): \VitexSoftware\Raiffeisenbank\Model\CurrencyListSimple
```



Returns foreign exchange rates for all available currencies.  This operation does not require a client certificate.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new \VitexSoftware\Raiffeisenbank\PremiumAPI\GetFxRatesListApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$date = new \DateTime("2013-10-20T19:20:30+01:00"); // \DateTime | The effective date for which the FX rates list is requested. Will default to **now** when not specified.

try {
    $result = $apiInstance->getFxRatesList( $xRequestId,  $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetFxRatesListApi->getFxRatesList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **date** | **\DateTime**| The effective date for which the FX rates list is requested. Will default to **now** when not specified. | [optional] |

### Return type

[**\VitexSoftware\Raiffeisenbank\Model\CurrencyListSimple**](../Model/CurrencyListSimple.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
