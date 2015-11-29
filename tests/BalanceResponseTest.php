<?php

namespace GifteryTests;

use Giftery\classes\response\BalanceResponse;

/**
 * Class BalanceResponseTest
 * @covers \Giftery\classes\response\ApiResponse
 * @covers \Giftery\classes\response\BalanceResponse
 * @package GifteryTests
 */
class BalanceResponseTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoBalanceKeyResponse()
	{
		new BalanceResponse('{"status":"ok","data":{}}');
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
