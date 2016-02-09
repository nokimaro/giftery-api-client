<?php

namespace Giftery;

use BadMethodCallException;
use Giftery\classes\data\OrderData;
use Giftery\classes\data\RequestData;
use Giftery\classes\exception\HttpException;
use Giftery\classes\response\ApiResponse;
use Giftery\classes\response\BalanceResponse;
use Giftery\classes\response\MakeOrderResponse;
use Giftery\classes\response\ProductsResponse;
use UnexpectedValueException;

/**
 * Class GifteryApiClient
 * @package Giftery
 */
class GifteryApiClient
{
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
	 * @var array
	 */
	protected $allowedMethods = [
		'getBalance',
		'getProducts',
		'makeOrder',
	];

	/**
     * GifteryApiClient constructor.
     * @param int $client_id
     * @param string $secret
     */
	public function __construct($client_id, $secret)
	{
		$this->clientId = $client_id;
		$this->secret = $secret;
	}

	/**
	 * Получение текущего баланса
	 * @return BalanceResponse
	 */
	public function callGetBalance()
	{
		return $this->call('getBalance', 'Giftery\classes\response\BalanceResponse');
	}

	/**
	 * Получение списка доступных для заказа сертификатов
	 * @return ProductsResponse
	 */
	public function callGetProducts()
	{
		return $this->call('getProducts', 'Giftery\classes\response\ProductsResponse');
	}

	/**
	 * Создание нового заказа
	 * @param OrderData $data
	 * @return MakeOrderResponse
	 */
	public function callMakeOrder(OrderData $data)
	{
		return $this->call('makeOrder', 'Giftery\classes\response\MakeOrderResponse', $data);
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
			throw new UnexpectedValueException("cmd не является строкой");
		} else {
			if (!in_array($cmd, $this->allowedMethods, true)) {
				throw new BadMethodCallException("Неизвестное значение cmd");
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

		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_URL            => $this->endpoint . '/?' . http_build_query($query),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST           => true,
			CURLOPT_HTTPHEADER     => [
				'User-Agent: Giftery Api client for PHP/0.1.0',
			],
			CURLOPT_POSTFIELDS     => http_build_query($body),
		]);

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
}
