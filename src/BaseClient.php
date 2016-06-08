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
    public $method;

    /**
     * @var string
     */
    private $_appKey;
    /**
     * @var string
     */
    private $_secret;
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
        if (empty($appKey) || empty($secret)) {
            throw new \InvalidArgumentException('Appkey and secret is required.');
        }

        $this->_appKey = $appKey;
        $this->_secret = $secret;

        $this->_params = static::getPublicParams();
    }

    /**
     * @return bool|Error|\cdcchen\alidayu\Response
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
        $this->method = $value;
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

    /**
     * @param null $name
     * @return array|bool|mixed
     */
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
    protected static function getPublicParams()
    {
        return [
            'timestamp' => date('Y-m-d H:i:s', time()),
            'format' => 'json',
            'v' => '2.0',
            'sign_method' => 'md5',
        ];
    }

    /**
     * @return array
     */
    protected static function getPublicRequireParams()
    {
        return ['method', 'app_key', 'timestamp', 'v', 'sign_method', 'sign'];
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
        $this->_params['method'] = $this->method;
        $sign = $this->generateSign();
        $this->_params['sign'] = $sign;

        $this->checkRequireParams();
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return [];
    }

    /**
     * check require params
     */
    private function checkRequireParams()
    {
        $requireParams = array_merge(static::getPublicRequireParams(), $this->getRequireParams());

        foreach ($requireParams as $param) {
            if (!isset($this->_params[$param])) {
                throw new \InvalidArgumentException("$param is required.");
            }
        }
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
     * @return \cdcchen\alidayu\Response
     */
    abstract protected function buildSuccessResponse(Response $response);

    /**
     * @param Response $response
     * @return bool|Error
     */
    protected function buildErrorResponse(Response $response)
    {
        $body = $response->getContent();
        $data = json_decode($body, true);
        if (isset($data['error_response'])) {
            return new Error($data['error_response']);
        }
        return false;
    }

    /**
     * @param Response $response
     * @return \cdcchen\alidayu\Response | Error
     */
    protected function afterExecute(Response $response)
    {
//        echo $response->getContent();
        return $this->buildErrorResponse($response) ?: $this->buildSuccessResponse($response);
    }

}