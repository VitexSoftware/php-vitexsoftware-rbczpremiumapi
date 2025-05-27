# # GetTransactionList200ResponseTransactionsInner

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**entryReference** | **string** | Unique identification of the realized transaction. |
**amount** | [**\VitexSoftware\Raiffeisenbank\Model\GetTransactionList200ResponseTransactionsInnerAmount**](GetTransactionList200ResponseTransactionsInnerAmount.md) |  |
**creditDebitIndication** | **string** |  |
**bookingDate** | **\DateTime** | Date of payment processing/posting by the bank. | [optional]
**valueDate** | **\DateTime** | Transaction date; value date; date which is used to count interest; e.g. date when money were withdrawn from ATM. | [optional]
**bankTransactionCode** | [**\VitexSoftware\Raiffeisenbank\Model\GetTransactionList200ResponseTransactionsInnerBankTransactionCode**](GetTransactionList200ResponseTransactionsInnerBankTransactionCode.md) |  |
**entryDetails** | [**\VitexSoftware\Raiffeisenbank\Model\GetTransactionList200ResponseTransactionsInnerEntryDetails**](GetTransactionList200ResponseTransactionsInnerEntryDetails.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
