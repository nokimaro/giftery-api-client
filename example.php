<?php

use Giftery\classes\exception\ApiException;
use Giftery\classes\data\OrderData;
use Giftery\GifteryApiClient;

include_once 'loader.php';

try {
    $order = new OrderData();
    $order->setProductId(342);
    $order->setFace(1000);
    $order->setComment('Раз-раз, проверка...');
    $order->setTestmode(true);

    $api = new GifteryApiClient(1, 'VeryVerySecretString');
    $response = $api->callMakeOrder($order);
    $queue_id = $response->getQueueId();
} catch (ApiException $e) {
    // Обработка ошибок API (например, недостаточно средств, неактивный продукт, превышен лимит и т.д.)
    $message = $e->getMessage();
    $code = $e->getCode();
    $raw_response = $e->getResponse(); // Ответ сервера для логирования
} catch (Exception $e) {
    // Обработка ошибок подключения к серверу, ошибок валиадации параметров и прочее
    $message = $e->getMessage();
}
