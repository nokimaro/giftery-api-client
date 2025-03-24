<?php

namespace Giftery\classes\data;

/**
 * Class CustomData
 * @package Giftery\classes\data
 */
class CustomData extends RequestData
{
    private array $properties = [];

    public function set(array $properties): void
    {
        foreach($properties as $key => $val)
        {
            $this->properties[$key] = $val;
        }
    }

    public function __toString()
    {
        return json_encode($this->properties);
    }
}
