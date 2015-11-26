<?php

namespace Giftery\classes\response;

use Giftery\classes\exception\ApiException;

/**
 * Class BalanceResponse
 * @package Giftery\classes\response
 */
class BalanceResponse extends ApiResponse
{
    /**
     * BalanceResponse constructor.
     * @param $response
     * @throws ApiException
     */
    public function __construct($response)
    {
        parent::__construct($response);

        if (!isset($this->response['data']['balance'])) {
            throw new ApiException('Отсутствует обязательный элемент ответа balance', -1, null, $this->getRawResponse());
        }
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        return (int)$this->response['data']['balance'];
    }
}
