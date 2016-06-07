<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/7
 * Time: 22:47
 */

namespace cdcchen\alidayu;


use cdcchen\net\curl\Client;
use cdcchen\net\curl\Response;

/**
 * Class BaseClient
 * @package cdcchen\alidayu
 */
abstract class BaseClient
{
    /**
     * @var string
     */
    private $_appKey;
    /**
     * @var string
     */
    private $_secret;
    /**
     * @var string
     */
    private $_method;
    /**
     * @var array
     */
    private $_params = [];
    /**
     * @var string
     */
    private $_gatewayUrl = 'http://gw.api.taobao.com/router/rest';

    /**
     * BaseClient constructor.
     * @param $appKey
     * @param $secret
     */
    public function __construct($appKey, $secret)
    {
        $this->_appKey = $appKey;
        $this->_secret = $secret;

        $this->_params = static::getPublicParams();
    }

    /**
     * @return bool|Response
     * @throws \cdcchen\net\curl\RequestException
     */
    public function execute()
    {
        if ($this->beforeExecute()) {
            $this->prepare();
            $response = Client::post($this->_gatewayUrl, $this->_params)->send();
            return $this->afterExecute($response);
        }

        return false;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setGatewayUrl($value)
    {
        $this->_gatewayUrl = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMethod($value)
    {
        $this->_method = $value;
        return $this;
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

    public function getParam($name = null)
    {
        if ($name === null) {
            return $this->_params;
        } else {
            return isset($this->_params[$name]) ? $this->_params[$name] : false;
        }
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

    /**
     * @return array
     */
    private static function getPublicParams()
    {
        return [
            'timestamp' => date('Y-m-d H:i:s', time()),
            'format' => 'json',
            'v' => '2.0',
            'sign_method' => 'md5',
        ];
    }

    /**
     * @return string
     */
    private function generateSign()
    {
        ksort($this->_params);

        $str = $this->_secret;
        foreach ($this->_params as $name => $value) {
            $str .= $name . $value;
        }
        $str .= $this->_secret;

        return strtoupper(md5($str));
    }

    /**
     * prepare for execute
     */
    private function prepare()
    {
        $this->_params['app_key'] = $this->_appKey;
        $this->_params['method'] = $this->_method;
        $sign = $this->generateSign();
        $this->_params['sign'] = $sign;
    }

    /**
     * @return bool
     */
    protected function beforeExecute()
    {
        return true;
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function afterExecute(Response $response)
    {
        return $response;
    }

}