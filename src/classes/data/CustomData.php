<?php

namespace Giftery\classes\data;

/**
 * Class GetProductsData
 * @package Giftery\classes\data
 */
class CustomData extends RequestData
{
    public function set(array $properties)
    {
        foreach($properties as $key => $val)
        {
            $this->{$key} = $val;
        }
    }

    public function __toString()
    {
        $result = [];
        $fields = (array)$this;

        foreach ($fields as $key => $value)
        {
            $result[$key] = $value;
        }

        return json_encode($result);
    }
}
