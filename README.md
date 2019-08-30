### Установка

Подключение клиента можно выполнить (при наличии) с помощью менеджера зависимостей composer или скачать в виде архива в соответствующем разделе.

```
composer require giftery/api-client
```

Процедура установки composer описана на странице https://getcomposer.org/download/

### Быстрый старт

```
<?php

use Giftery\classes\exception\ApiException;
use Giftery\classes\data\OrderData;
use Giftery\GifteryApiClient;

// Раскомментируйте следующую строку, если не используется composer
//include_once 'loader.php';

try {
    $order = new OrderData();

    $order->setProductId(343);
    $order->setFace(1000);
    $order->setComment('Раз-раз, проверка...');
    $order->setTestmode(true);

    // Или

    $order->set([
        'product_id' => 343,
        'face' => 1000,
        'comment' => 'Раз-раз, проверка...',
        'testmode' => true,
    ]);

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
```

### Список доступных методов GifteryApiClient

* callGetBalance()
* callGetProducts()
* callMakeOrder(OrderData $data)

### callGetBalance()

Возвращает объект класса `BalanceResponse`, в котором предусмотрен метод `getBalance`, который вернёт текущий баланс в виде целого числа.

```
<?php

try {
    $api = new GifteryApiClient(1, 'VeryVerySecretString');
    $response = $api->callGetBalance();
    echo $response->getBalance(); // 1000
} catch (Exception $e) {
    // Обработка ошибок
}
```

### callGetProducts()

Возвращает объект класса `ProductsResponse`, в котором предусмотрен метод `getProducts`, который вернёт массив массивов сертификатов с описанием.
Каждый сертификат описывается набором полей:

* `id` - уникальный идентификатор сертификата (целое положительное число), используется при заказе;
* `title` - название сертификата (строка);
* `url` - ссылка на страницу с описанием сертификата (строка);
* `brief` - краткое описание сертификата и/или бренда (строка);
* `faces` - массив доступных для заказа номиналов сертификатов, **0** - свободный номинал в интервале от `face_min` до `face_max` включительно (массив целых неотрицательных чисел);
* `face_min` - минимальный доступный номинал данного серфтиката (целое положительное число);
* `face_max` - максимальный доступный номинал данного серфтиката (целое положительное число);
* `disclaimer` - правила и ограничения (строка);
* `image_url` - ссылка на изображение бренда, добавляемое на сертификат (строка).

```
<?php

try {
    $api = new GifteryApiClient(1, 'VeryVerySecretString');
    $response = $api->callGetProducts();
    print_r($response->getProducts());
} catch (Exception $e) {
    // Обработка ошибок
}
```

### callMakeOrder(OrderData $data)

Возвращает объект класса `MakeOrderResponse`, в котором предусмотрен метод `getQueueId`, который вернёт уникальный идентификатор в очереди заказов (целое неотрицательное число).

Для работы метода требуется в качестве аргумента объект класса OrderData. OrderData представляет собой набор методов, для установки параметров заказа.

```
<?php

$order = new OrderData();
$order->setProductId(342);
$order->setFace(1000);
$order->setComment('Раз-раз, проверка...');
$order->setTestmode(true);
```

В случае передачи в некоторые методы неверного значения выбрасывается `UnexpectedValueException`.

```
<?php

try {
    $order = new OrderData();
    $order->setProductId('Строка');
} catch (UnexpectedValueException $e) {
    echo $e->getMessage(); // Значение product_id должно быть положительным целым числом
}
```

```
<?php

try {
    $order = new OrderData();
    $order->setProductId(343);
    $order->setFace(1000);
    $order->setComment('Раз-раз, проверка...');
    $order->setTestmode(true);

    $api = new GifteryApiClient(1, 'VeryVerySecretString');
    $response = $api->callMakeOrder($order);
    $queue_id = $response->getQueueId();
} catch (Exception $e) {
    // Обработка ошибок
}
```

### История изменений ###

`0.2`

* Добавлены методы `setUuid()`, `setToPhone()`, `setDateSend()`, `setExternalId()`, `setDeliveryType()`

`0.1.3`

* Исправление валидации параметра `testmode`

`0.1.2`

* Добавлено свойство `extended` при запросе `getProducts`

`0.1.1`

* Добавлен метод `setVersion()` для указания версии API (`GifteryApiBase`)
* Добавлен метод `set()` для установки массива свойств (`RequestData`)
* Добавлены методы `post()`/`get()` для указания метода обращения к API (`GifteryApiBase`)
* Private свойства (`$clientId`, `$secret`, etc) имеют область видимости protected

`0.1.0`

* Первый релиз
