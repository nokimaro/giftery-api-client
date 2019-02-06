<?php

namespace Giftery\classes\data;

use Instasent\SMSCounter\SMSCounter;

/**
 * Class PushSmsData
 * @package Giftery\classes\data
 */
class PushSmsData extends RequestData
{
    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $text;

    /**
     * @param string $to
     * @throws \UnexpectedValueException Выбрасывается, если в качестве значения агрумента передать не строку или номер
     *     телефона в неправильном формате
     */
    public function setTo($to)
    {
        if (!is_string($to) || !preg_match("/^79\d{9}$/D", $to)) {
            throw new \UnexpectedValueException("Значение to должно быть строкой в формате 79001234567");
        }

        $this->to = $to;
    }

    /**
     * @param string $text
     * @throws \UnexpectedValueException Выбрасывается, если в качестве агрумента аргумента передать не строку или
     *     пустую строку
     * @throws \RangeException Выбрасывается, если текст смс сообщения превышает три части
     */
    public function setText($text)
    {
        if (!is_string($text) || strlen($text) === 0) {
            throw new \UnexpectedValueException("Значение text должно быть непустой строкой");
        }

        $counter = new SMSCounter();
        $info = $counter->count($text);

        if ($info->messages > 3) {
            throw new \RangeException("Количество частей в одной смс не должно превышать 3");
        }

        $this->text = $text;
    }
}
