<?php

namespace GifteryTests;

use Giftery\classes\response\ProductsResponse;

/**
 * Class BalanceResponseTest
 * @covers \Giftery\classes\response\ApiResponse
 * @covers \Giftery\classes\response\ProductsResponse
 * @package GifteryTests
 */
class ProductsResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testProductsResponse()
    {
        $response = new ProductsResponse('{"status":"ok","data":[]}');
        $this->assertSame([], $response->getProducts());
    }
}
