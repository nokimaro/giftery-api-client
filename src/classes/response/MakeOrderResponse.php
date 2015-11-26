<?php

namespace Giftery\classes\response;

use Giftery\classes\exception\ApiException;

/**
 * Class MakeOrderResponse
 * @package Giftery\classes\response
 */
class MakeOrderResponse extends ApiResponse
{
    /**
     * MakeOrderResponse constructor.
     * @param string $response
     * @throws ApiException
     */
    public function __construct($response)
    {
        parent::__construct($response);

        if (!isset($this->response['data']['id'])) {
            throw new ApiException('Отсутствует обязательный элемент ответа id', -1, null, $this->getRawResponse());
        }
    }

    /**
     * @return int
     */
    public function getQueueId()
    {
        return (int)$this->response['data']['id'];
    }
}
