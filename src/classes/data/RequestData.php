<?php

namespace Giftery\classes\data;

/**
 * Class RequestData
 * @package Giftery\classes\data
 */
abstract class RequestData
{
	/**
	 * Метод для установки нескольких свойств через массив ключ-значение. Для каждого элемента массива будет вызван
	 * соответствующий ему метод (например, элементу order_id будет вызван метод setOrderId), если метод не существует
	 * - выбрасывается исключение.
	 * @param array $properties
	 */
	public function set(array $properties)
	{
		foreach ($properties as $name => $value) {
			$method = 'set' . str_replace('_', '', $name);

			if (!method_exists($this, $method)) {
				throw new \BadMethodCallException('Не найден метод ' . $method);
			}

			call_user_func([$this, $method], $value);
		}
	}

	/**
	 * @return string
	 */
	public function toJson()
	{
		return $this->__toString();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
        $result = [];
		$fields = (array)$this;

        foreach ($fields as $key => $value) {
            // Имена приватных свойств обозначаются как "\0Giftery\classes\request\OrderData\0product_id"
            $chunks = explode("\0", $key);

            if (count($chunks) === 3 && $chunks[1] !== '*') {
                if ($value !== null) {
                    $result[$chunks[2]] = $value;
                }
            }
        }

		return json_encode($result);
	}
}
