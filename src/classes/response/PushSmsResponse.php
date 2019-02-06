<?php

namespace Giftery\classes\response;

use Giftery\classes\exception\ApiException;

/**
 * Class PushSmsResponse
 * @package Giftery\classes\response
 */
class PushSmsResponse extends ApiResponse
{
    /**
     * PushSmsResponse constructor.
     * @param string $response
     * @throws \Giftery\classes\exception\ApiException
     */
    public function __construct($response)
    {
        parent::__construct($response);

        if (!isset($this->response['data']['queue_id'])) {
            throw new ApiException('Отсутствует обязательный элемент ответа queue_id', -1, null,
                $this->getRawResponse());
        }
    }

    /**
     * @return int
     */
    public function getQueueId()
    {
        return (int)$this->response['data']['queue_id'];
    }
}
