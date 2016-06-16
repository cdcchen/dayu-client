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