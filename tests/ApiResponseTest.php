<?php

namespace GifteryTests;

use Giftery\classes\response\BalanceResponse;

/**
 * Class ApiResponseTest
 * @covers \Giftery\classes\response\ApiResponse
 * @package GifteryTests
 */
class ApiResponseTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNonStringResponse()
	{
		new BalanceResponse(null);
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testEmptyStringResponse()
	{
		new BalanceResponse('');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNonJsonResponse()
	{
		new BalanceResponse('<html></html>');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoStatusKeyResponse()
	{
		new BalanceResponse('{}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testUnknownStatusResponse()
	{
		new BalanceResponse('{"status":"..."}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoErrorKeyResponse()
	{
		new BalanceResponse('{"status":"error"}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoErrorCodeKeyResponse()
	{
		new BalanceResponse('{"status":"error","error":{"text":"..."}}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoErrorTextKeyResponse()
	{
		new BalanceResponse('{"status":"error","error":{"code":"..."}}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode 1000
	 * @expectedExceptionMessage ...
	 */
	public function testFullErrorResponse()
	{
		new BalanceResponse('{"status":"error","error":{"code":1000,"text":"..."}}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNoDataKeyResponse()
	{
		new BalanceResponse('{"status":"ok"}');
	}

	/**
	 * @expectedException \Giftery\classes\exception\ApiException
	 * @expectedExceptionCode -1
	 */
	public function testNonArrayDataResponse()
	{
		new BalanceResponse('{"status":"ok","data":1}');
	}
}
