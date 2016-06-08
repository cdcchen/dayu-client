<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/8
 * Time: 10:05
 */

namespace cdcchen\alidayu;


/**
 * Class Error
 * @package cdcchen\alidayu
 */
/**
 * Class Error
 * @package cdcchen\alidayu
 */
class Error
{
    /**
     * @var array
     */
    private $_data;

    /**
     * Error constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->_data = $data;
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

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : null;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->_data;
    }
}