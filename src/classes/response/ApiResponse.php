<?php

namespace Giftery\classes\response;

use Giftery\classes\exception\ApiException;

/**
 * Class ApiResponse
 * @package Giftery\classes\response
 */
abstract class ApiResponse
{
    /**
     * @var array
     */
    protected $response = [];

    /**
     * @var mixed
     */
    protected $rawResponse;

    /**
     * ApiResponse constructor.
     * @param $response
     * @throws ApiException
     */
    public function __construct($response)
    {
        if (!is_string($response)) {
            throw new ApiException('Полученный ответ сервера не является строкой', -1, null, $response);
        } else {
            if (strlen($response) === 0) {
                throw new ApiException('Получен пустой ответ сервера', -1, null, $response);
            }
        }

        $this->response = json_decode($response, true);

        if ($this->response === null || !is_array($this->response)) {
            throw new ApiException('Полученный ответ не является JSON строкой', -1, null, $response);
        }

        if (!isset($this->response['status'])) {
            throw new ApiException('Отсутствует обязательный элемент ответа status', -1, null, $response);
        }

        if ($this->response['status'] !== 'ok' && $this->response['status'] !== 'error') {
            throw new ApiException('Неизвестный статус ответа', -1, null, $response);
        }

        if ($this->response['status'] === 'error') {
            if (!isset($this->response['error'])) {
                throw new ApiException('Отсутствует обязательный элемент ошибки error', -1, null, $response);
            } else {
                if (!isset($this->response['error']['code']) || !isset($this->response['error']['text'])) {
                    throw new ApiException('Отсутствует обязательный элемент ошибки code/text', -1, null, $response);
                }
            }

            throw new ApiException($this->response['error']['text'], $this->response['error']['code'], null, $response);
        }

        if (!isset($this->response['data'])) {
            throw new ApiException('Отсутствует обязательный элемент ответа data', -1, null, $response);
        } else {
            if (!is_array($this->response['data'])) {
                throw new ApiException('Элемент ответа data не является массивом', -1, null, $response);
            }
        }

        $this->rawResponse = $response;
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }
}
