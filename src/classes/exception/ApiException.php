<?php

namespace Giftery\classes\exception;

use Exception;

/**
 * Class ApiException
 * @package Giftery\classes\exception
 */
class ApiException extends Exception
{
    /**
     * @var mixed
     */
    protected $response;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @param mixed $response
     */
    public function __construct($message, $code, Exception $previous = null, $response = null)
    {
        $this->response = $response;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
