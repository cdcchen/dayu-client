<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/14
 * Time: 11:50
 */

namespace cdcchen\alidayu;


/**
 * Class BaseResponse
 * @package cdcchen\alidayu
 */
abstract class BaseResponse
{
    /**
     * @var array
     */
    private $_data;

    /**
     * @return bool
     */
    abstract public function isOK();

    /**
     * Error constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->_data = $data;
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