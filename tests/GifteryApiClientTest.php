<?php

namespace GifteryTests;

use Giftery\GifteryApiClient;

class GifteryApiClientTest extends \PHPUnit_Framework_TestCase
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
     * @covers \Giftery\GifteryApiClient::call
     * @expectedException \UnexpectedValueException
     */
    public function testCallWithWrongCmdType()
    {
        $this->api->call(null, 'bar');
    }

    /**
     * @covers \Giftery\GifteryApiClient::call
     * @expectedException \BadMethodCallException
     */
    public function testCallWithUnknownCmd()
    {
        $this->api->call('foo', 'bar');
    }

    /**
     * @covers \Giftery\GifteryApiClient::call
     * @expectedException \Giftery\classes\exception\HttpException
     */
    public function testCallWhenCurlReturnsFalse()
    {
        $this->api->setEndpoint('http://' . md5(uniqid()) . '.local');
        $this->api->call('getBalance', '');
    }

    /**
     * @covers \Giftery\GifteryApiClient::call
     * @expectedException \Giftery\classes\exception\HttpException
     */
    public function testCallWhenCurlReturnsNot200Status()
    {
        $this->api->setEndpoint('http://www.mocky.io/v2/5657845d1100004f3b07be52');
        $this->api->call('getBalance', '');
    }
}
