<?php

/**
 * GetAccountsApiTest
 * PHP version 7.4
 *
 * @category Class
 * @package  VitexSoftware\Raiffeisenbank
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 *
 * The version of the OpenAPI document: 1.1.20230222
 * Contact: info@vitexsoftware.cz
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.4.0
 */

namespace VitexSoftware\Raiffeisenbank\Test\Api;

use \PHPUnit\Framework\TestCase,
    \VitexSoftware\Raiffeisenbank\ApiClient,
    \VitexSoftware\Raiffeisenbank\PremiumAPI\GetAccountsApi;

/**
 * GetAccountsApiTest Class Doc Comment
 *
 * @category Class
 * @package  VitexSoftware\Raiffeisenbank
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class GetAccountsApiTest extends TestCase
{

    /**
     * 
     * @var GetAccountsApi
     */
    protected $object;

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass(): void
    {
        
    }

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
        $this->object = new GetAccountsApi(new ApiClient(['mocking' => true]));
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown(): void
    {
        
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass(): void
    {
        
    }

    /**
     * Test case for getAccounts
     *
     * .
     *
     */
    public function testGetAccounts()
    {
        $account = $this->object->getAccounts(time());
        $this->assertArrayHasKey('accounts', $account);
    }
}
