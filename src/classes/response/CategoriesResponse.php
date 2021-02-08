<?php

namespace Giftery\classes\response;

/**
 * Class ProductsResponse
 * @package Giftery\classes\response
 */
class CategoriesResponse extends ApiResponse
{
    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->response['data'];
    }
}
