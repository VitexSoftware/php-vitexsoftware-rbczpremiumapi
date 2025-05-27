# VitexSoftware\Raiffeisenbank\GetFxRatesApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getFxRates()**](GetFxRatesApi.md#getFxRates) | **GET** /rbcz/premium/api/fxrates/{currencyCode} |  |


## `getFxRates()`

```php
getFxRates( $xRequestId, $currencyCode,  $date): \VitexSoftware\Raiffeisenbank\Model\CurrencyListSimple
```



Returns foreign exchange rates for the given currency code.  This operation does not require a client certificate.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new \VitexSoftware\Raiffeisenbank\PremiumAPI\GetFxRatesApi(
    new \VitexSoftware\Raiffeisenbank\ApiClient(['clientpubip'=> \VitexSoftware\Raiffeisenbank\ApiClient::getPublicIP() ,'debug'=>true])
);
$xRequestId = 'xRequestId_example'; // string | Unique request id provided by consumer application for reference and auditing.
$currencyCode = 'currencyCode_example'; // string | The foreign currency code in ISO-4217 format.
$date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The effective date for which the FX rates are requested. Will default to **now** when not specified.

try {
    $result = $apiInstance->getFxRates( $xRequestId, $currencyCode,  $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetFxRatesApi->getFxRates: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **xRequestId** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **currencyCode** | **string**| The foreign currency code in ISO-4217 format. | |
| **date** | **\DateTime**| The effective date for which the FX rates are requested. Will default to **now** when not specified. | [optional] |

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
