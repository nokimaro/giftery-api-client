<?php

namespace Giftery;

use Giftery\classes\data\GetProductsData;
use Giftery\classes\data\OrderData;
use Giftery\classes\GifteryApiBase;
use Giftery\classes\response\BalanceResponse;
use Giftery\classes\response\MakeOrderResponse;
use Giftery\classes\response\ProductsResponse;
use Giftery\classes\response\CategoriesResponse;
use Giftery\classes\response\SendResponse;

/**
 * Class GifteryApiClient
 * @package Giftery
 */
class GifteryApiClient extends GifteryApiBase
{
    /**
     * @var array
     */
    protected $allowedMethods = [
        'getBalance',
        'getProducts',
        'makeOrder',
        'getCategories',
        'getCertificate',
        'getCode',
        'getLinks',
        'getStatus',
    ];

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
     * @param GetProductsData $data
     * @return ProductsResponse
     * @throws classes\exception\HttpException
     */
    public function callGetProducts(?GetProductsData $data = null)
    {
        return $this->call('getProducts', 'Giftery\classes\response\ProductsResponse', $data);
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
     * Получение списка категорий
     * @return CategoriesResponse
     * @throws classes\exception\HttpException
     */
    public function callGetCategories()
    {
        return $this->call('getCategories', 'Giftery\classes\response\CategoriesResponse');
    }

    /**
     * Получение списка категорий
     * @return SendResponse
     */
    public function send($method, ?$data = null)
    {
        return $this->call($method, 'Giftery\classes\response\SendResponse', $data);
    }
}
