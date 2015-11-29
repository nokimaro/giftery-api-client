<?php

namespace GifteryTests;

use Giftery\classes\response\MakeOrderResponse;

/**
 * Class BalanceResponseTest
 * @covers \Giftery\classes\response\ApiResponse
 * @covers \Giftery\classes\response\MakeOrderResponse
 * @package GifteryTests
 */
class MakeOrderResponseTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoIdKeyResponse()
	{
		new MakeOrderResponse('{"status":"ok","data":{}}');
	}

	public function testNormalIdResponse()
	{
		$response = new MakeOrderResponse('{"status":"ok","data":{"id":100}}');
		$this->assertSame(100, $response->getQueueId());
	}

	public function testZeroReturnWhenNonNumericIdResponse()
	{
		$response = new MakeOrderResponse('{"status":"ok","data":{"id":"..."}}');
		$this->assertSame(0, $response->getQueueId());
	}
}
