<?php

namespace Giftery\classes;

use Giftery\classes\data\RequestData;
use Giftery\classes\exception\HttpException;
use Giftery\classes\response\ApiResponse;

/**
 * Class GifteryApiBase
 * @package Giftery
 */
abstract class GifteryApiBase
{
    const HTTP_GET = 0;
    const HTTP_POST = 1;

    /**
     * @var int
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $endpoint = 'https://ssl-api.giftery.ru';

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var array
     */
    protected $allowedMethods = [];

    /**
     * GifteryApiBase constructor.
     * @param int $client_id
     * @param string $secret
     */
    public function __construct($client_id, $secret)
    {
        $this->method = self::HTTP_GET;

        $this->clientId = $client_id;
        $this->secret = $secret;
    }

    /**
     * Флаг выполнения следующих запросов к методам API посредством GET
     * @return $this
     */
    public function get()
    {
        $this->method = self::HTTP_GET;

        return $this;
    }

    /**
     * Флаг выполнения следующих запросов к методам API посредством POST
     * @return $this
     */
    public function post()
    {
        $this->method = self::HTTP_POST;

        return $this;
    }

    /**
     * @param string $cmd
     * @param string $responseClass
     * @param RequestData|null $data
     * @return ApiResponse
     * @throws HttpException
     */
    public function call($cmd, $responseClass, RequestData $data = null)
    {
        if (!is_string($cmd)) {
            throw new \UnexpectedValueException("cmd не является строкой");
        } else {
            if (!in_array($cmd, $this->allowedMethods, true)) {
                throw new \BadMethodCallException("Неизвестное значение cmd");
            }
        }

        $query = [
            'cmd' => $cmd,
            'id' => $this->clientId,
            'in' => 'json',
            'out' => 'json',
        ];

        $json = $data !== null ? $data->toJson() : '{}';

        $body = [
            'data' => $json,
            'sig'  => $this->createSig($cmd, $json),
        ];

        if ($this->method === self::HTTP_GET) {
            $query = array_merge($query, $body);
            $body = [];
        }

        if ($this->version !== null) {
            $query['v'] = $this->version;
        }

        $options = [
            CURLOPT_URL            => $this->endpoint . '/?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'User-Agent: Giftery Api client for PHP/0.2',
            ],
        ];

        if ($this->method === self::HTTP_POST) {
            $options += [
                CURLOPT_POST       => true,
                CURLOPT_POSTFIELDS => http_build_query($body),
            ];
        }

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $answer = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($answer !== false) {
            if ($http_code === 200) {
                return new $responseClass($answer);
            } else {
                throw new HttpException(sprintf('Неожиданный HTTP код ответа сервера (%d)', $http_code));
            }
        } else {
            throw new HttpException(sprintf('%s (%d)', $error, $errno));
        }
    }

    /**
     * @param string $cmd
     * @param string $data
     * @return string
     */
    private function createSig($cmd, $data)
    {
        return hash('sha256', $cmd . $data . $this->secret);
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
}
