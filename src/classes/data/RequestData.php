<?php

namespace Giftery\classes\data;

/**
 * Class RequestData
 * @package Giftery\classes\data
 */
abstract class RequestData
{
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
