<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/8
 * Time: 10:05
 */

namespace cdcchen\alidayu;


/**
 * Class ErrorResponse
 * @package cdcchen\alidayu
 */
class ErrorResponse extends BaseResponse
{
    /**
     * @return bool
     */
    public function isOK()
    {
        return false;
    }

    /**
     * @return mixed|null
     */
    public function getCode()
    {
        return $this->get('code');
    }

    /**
     * @return mixed|null
     */
    public function getSubCode()
    {
        return $this->get('sub_code');
    }

    /**
     * @return mixed|null
     */
    public function getMsg()
    {
        return $this->get('msg');
    }

    /**
     * @return mixed|null
     */
    public function getSubMsg()
    {
        return $this->get('sub_msg');
    }
}