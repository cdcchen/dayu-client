<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/14
 * Time: 14:50
 */

namespace cdcchen\alidayu;


/**
 * Class SmsSendResponse
 * @package cdcchen\alidayu
 */
class SmsSendResponse extends Response
{
    /**
     * @param string|null $name
     * @return mixed|null
     */
    public function getResult($name = null)
    {
        $result = $this->get('result');
        if ($result && $name) {
            return isset($result[$name]) ? $result[$name] : null;
        }

        return $result;
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->getResult('err_code');
    }

    /**
     * @return string|null
     */
    public function getModel()
    {
        return $this->getResult('model');
    }

    /**
     * @return bool|null
     */
    public function getSuccess()
    {
        return $this->getResult('success');
    }
}