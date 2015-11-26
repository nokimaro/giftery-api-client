<?php

namespace Giftery\classes\data;

use UnexpectedValueException;

/**
 * Class OrderData
 * @package Giftery\classes\data
 */
class OrderData extends RequestData
{
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
    private $text;

    /**
     * @var string
     */
    private $comment;

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
     * @param bool $testmode
     */
    public function setTestmode($testmode)
    {
        if (!filter_var($testmode, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            throw new UnexpectedValueException("Значение testmode не является булевым значением");
        }

        $this->testmode = $testmode ? 1 : 0;
    }
}
