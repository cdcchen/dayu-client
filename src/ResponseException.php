<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 09:22
 */

namespace cdcchen\alidayu;


use Exception;

/**
 * Class ResponseException
 * @package cdcchen\alidayu
 */
class ResponseException extends Exception
{
    /**
     * @var
     */
    protected $subCode;
    /**
     * @var
     */
    protected $subMessage;

    /**
     * ResponseException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


    /**
     * @param string $value
     * @return mixed
     */
    public function setSubCode($value)
    {
        return $this->subCode = $value;
    }

    /**
     * @return string
     */
    public function getSubCode()
    {
        return $this->subCode;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function setSubMessage($value)
    {
        return $this->subMessage = $value;
    }

    /**
     * @return string
     */
    public function getSubMsg()
    {
        return $this->subMessage;
    }
}