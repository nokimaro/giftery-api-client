<?php

namespace Giftery\classes\data;

/**
 * Class GetProductsData
 * @package Giftery\classes\data
 */
class GetProductsData extends RequestData
{
    /**
     * @var string
     */
    private $extended;

    /**
     * @param string $extended
     */
    public function setExtended($extended)
    {
        if (!preg_match('#^([-_a-z]+)(,[-_a-z]+)*$#', $extended)) {
            throw new \UnexpectedValueException('Значение extended должно содержать список полей через запятую');
        }

        $this->extended = $extended;
    }
}
