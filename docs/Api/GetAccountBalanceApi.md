# OpenAPI\Client\GetAccountBalanceApi

All URIs are relative to https://api.rb.cz, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getBalance()**](GetAccountBalanceApi.md#getBalance) | **GET** /rbcz/premium/mock/accounts/{accountNumber}/balance |  |


## `getBalance()`

```php
getBalance($x_ibm_client_id, $x_request_id, $account_number, $psu_ip_address): \OpenAPI\Client\Model\GetBalance200Response
```



Get balance for given accounts.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GetAccountBalanceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_ibm_client_id = 'x_ibm_client_id_example'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = 'x_request_id_example'; // string | Unique request id provided by consumer application for reference and auditing.
$account_number = 'account_number_example'; // string | The number of account without prefix and bankCode
$psu_ip_address = 'psu_ip_address_example'; // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible.

try {
    $result = $apiInstance->getBalance($x_ibm_client_id, $x_request_id, $account_number, $psu_ip_address);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetAccountBalanceApi->getBalance: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_ibm_client_id** | **string**| ClientID obtained from Developer Portal - when you registered your app with us. | |
| **x_request_id** | **string**| Unique request id provided by consumer application for reference and auditing. | |
| **account_number** | **string**| The number of account without prefix and bankCode | |
| **psu_ip_address** | **string**| IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. Always provide the closest IP address to the real end-user possible. | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetBalance200Response**](../Model/GetBalance200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
