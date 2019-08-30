<?php

namespace GifteryTests;

use Giftery\classes\response\BalanceResponse;
use Giftery\GifteryApiClient;

/**
 * Class BalanceResponseTest
 * @covers \Giftery\classes\response\ApiResponse
 * @covers \Giftery\classes\response\BalanceResponse
 * @package GifteryTests
 */
class BalanceResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GifteryApiClient
     */
    private $api;

    protected function setUp()
    {
        $this->api = new GifteryApiClient(1, 'VeryVerySecretString');
    }

    /**
     * @expectedException \Giftery\classes\exception\ApiException
     * @expectedExceptionCode -1
     */
    public function testNoBalanceKeyResponse()
    {
        new BalanceResponse('{"status":"ok","data":{}}');
    }

    /**
     * @covers \Giftery\GifteryApiClient::call
     * @covers \Giftery\GifteryApiClient::callGetBalance
     */
    public function testSuccessfulResponse()
    {
        $this->api->setEndpoint('http://www.mocky.io/v2/56b9ae97120000932f0d0ad9');
        $response = $this->api->callGetBalance();
        $this->assertSame(100, $response->getBalance());
    }

    public function testNormalBalanceResponse()
    {
        $response = new BalanceResponse('{"status":"ok","data":{"balance":100}}');
        $this->assertSame(100, $response->getBalance());
    }

    public function testZeroReturnWhenNonNumericBalanceResponse()
    {
        $response = new BalanceResponse('{"status":"ok","data":{"balance":"..."}}');
        $this->assertSame(0, $response->getBalance());
    }
}
