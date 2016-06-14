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
abstract class BaseResponse extends Object
{
    /**
     * @var array
     */
    private $_data;

    /**
     * @return bool
     */
    public function isOK()
    {
        return isset($this->_data['code']);
    }

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