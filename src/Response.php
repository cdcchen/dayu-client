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