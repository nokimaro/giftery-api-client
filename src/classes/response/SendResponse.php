<?php

namespace Giftery\classes\response;

/**
 * Class ProductsResponse
 * @package Giftery\classes\response
 */
class SendResponse extends ApiResponse
{
    /**
     * @return array
     */
    public function getData()
    {
        return $this->response['data'];
    }
}
