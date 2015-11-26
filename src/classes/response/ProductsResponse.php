<?php

namespace Giftery\classes\response;

/**
 * Class ProductsResponse
 * @package Giftery\classes\response
 */
class ProductsResponse extends ApiResponse
{
    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->response['data'];
    }
}
