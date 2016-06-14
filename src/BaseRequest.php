<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/7
 * Time: 22:47
 */

namespace cdcchen\alidayu;


/**
 * Class BaseClient
 * @package cdcchen\alidayu
 */
abstract class BaseRequest extends Object
{
    /**
     * @var string
     */
    public $method;
    /**
     * @var array
     */
    private $_params = [];

    /**
     * BaseClient constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * init
     */
    public function init()
    {
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setParam($name, $value)
    {
        $this->_params[$name] = $value;
        return $this;
    }

    /**
     * @param null|string $name
     * @return array|bool|mixed
     */
    public function getParam($name)
    {
        return isset($this->_params[$name]) ? $this->_params[$name] : false;
    }

    /**
     * @return array|bool|mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        foreach ($params as $name => $value) {
            $this->setParam($name, $value);
        }

        return $this;
    }

    public function getResponseClass()
    {
        return SuccessResponse::className();
    }

    public function beforeExecute()
    {
        $this->prepare();
        $this->setParam('method', $this->method);
        $this->checkRequireParams();
    }

    /**
     * @return array
     */
    abstract protected function getRequireParams();

    protected function prepare()
    {
    }

    /**
     * check require params
     */
    private function checkRequireParams()
    {
        $requireParams = $this->getRequireParams();

        foreach ($requireParams as $param) {
            if (empty($this->_params[$param])) {
                throw new \InvalidArgumentException("$param is required.");
            }
        }
    }
}