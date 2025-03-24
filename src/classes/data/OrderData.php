<?php

namespace Giftery\classes\data;

use UnexpectedValueException;

/**
 * Class OrderData
 * @package Giftery\classes\data
 */
class OrderData extends RequestData
{
    const DATETIME_REGEXP = '/^\d{4}-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) ([01][0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$/';

    /**
     * @var int
     */
    private $product_id;

    /**
     * @var int
     */
    private $face;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $email_from;

    /**
     * @var string
     */
    private $email_to;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $to_phone;

    /**
     * @var string
     */
    private $date_send;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $external_id;

    /**
     * @var string
     */
    private $delivery_type;

    /**
     * @var string
     */
    private $callback;

    /**
     * @var int
     */
    private $testmode;

    /**
     * @param int $product_id
     */
    public function setProductId($product_id)
    {
        if (!filter_var($product_id, FILTER_VALIDATE_INT) || $product_id <= 0) {
            throw new UnexpectedValueException("Значение product_id должно быть положительным целым числом");
        }

        $this->product_id = $product_id;
    }

    /**
     * @param int $face
     */
    public function setFace($face)
    {
        if (!filter_var($face, FILTER_VALIDATE_INT) || $face <= 0) {
            throw new UnexpectedValueException("Значение face должно быть положительным целым числом");
        }

        $this->face = $face;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        if (!preg_match("#^[_A-Z0-9]+$#", $code)) {
            throw new UnexpectedValueException("Значение code должно содержать заглавные символы латиницы, цифры и нижнее подчёркивание");
        }
        $this->code = $code;
    }

    /**
     * @param string $email_from
     */
    public function setEmailFrom($email_from)
    {
        if (!filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
            throw new UnexpectedValueException("Значение email_from не является адресом email");
        }

        $this->email_from = $email_from;
    }

    /**
     * @param string $email_to
     */
    public function setEmailTo($email_to)
    {
        if (!filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
            throw new UnexpectedValueException("Значение email_to не является адресом email");
        }

        $this->email_to = $email_to;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @param string $to_phone
     */
    public function setToPhone($to_phone)
    {
        if (!preg_match("/^\d+$/", $to_phone)) {
            throw new UnexpectedValueException("Значение to_phone должно содержать только цифры");
        }

        $this->to_phone = $to_phone;
    }

    /**
     * @param string $date_send
     */
    public function setDateSend($date_send)
    {
        if (!preg_match(self::DATETIME_REGEXP, $date_send)) {
            throw new UnexpectedValueException("Значение date_send должно быть в формате Y-m-d H:i:s");
        }

        $this->date_send = $date_send;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param string $external_id
     */
    public function setExternalId($external_id)
    {
        $this->external_id = $external_id;
    }

    /**
     * @param string $delivery_type
     */
    public function setDeliveryType($delivery_type)
    {
        $this->delivery_type = $delivery_type;
    }

    /**
     * @param string $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param bool|int $testmode
     */
    public function setTestmode($testmode)
    {
        if (filter_var($testmode, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            throw new UnexpectedValueException("Значение testmode не является булевым значением");
        }

        $this->testmode = $testmode ? 1 : 0;
    }
}
