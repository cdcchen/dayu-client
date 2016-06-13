<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/8
 * Time: 09:59
 */

namespace cdcchen\alidayu;


/**
 * Class Response
 * @package cdcchen\alidayu
 */
class Response
{
    /**
     * @var array
     */
    private $_data;

    /**
     * Response constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->_data = $data;
    }

    /**
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed|null
     */
    public function get($name, $defaultValue = null)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : $defaultValue;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->_data;
    }
}