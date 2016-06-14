<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/7
 * Time: 22:47
 */

namespace cdcchen\alidayu;


use cdcchen\net\curl\Client as CUrlClient;
use cdcchen\net\curl\Response as CurlResponse;

/**
 * Class BaseCUrlClient
 * @package cdcchen\alidayu
 */
class Client extends Object
{
    /**
     * Api version
     */
    const VERSION = '2.0';
    /**
     * Json format
     */
    const FORMAT_JSON = 'json';
    /**
     * XML format
     */
    const FORMAT_XML = 'xml';
    /**
     * Sign method md5
     */
    CONST SIGN_METHOD_MD5 = 'md5';

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
    private $_restUrl = 'http://gw.api.taobao.com/router/rest';

    /**
     * BaseCUrlClient constructor.
     * @param $appKey
     * @param $secret
     */
    public function __construct($appKey = null, $secret = null)
    {
        $this->setAppKeySecret($appKey, $secret)
             ->setDefaultParams()
             ->init();
    }

    /**
     * init
     */
    protected function init()
    {
    }

    /**
     * @param $appKey
     * @param $secret
     * @return $this
     */
    public function setAppKeySecret($appKey, $secret)
    {
        $this->_appKey = $appKey;
        $this->_secret = $secret;
        $this->setParam('app_key', $appKey);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setRestUrl($value)
    {
        $this->_restUrl = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMethod($value)
    {
        $this->setParam('method', $value);
        return $this;
    }

    /**
     * @return array|bool|mixed
     */
    public function getMethod()
    {
        return $this->getParam('method');
    }

    /**
     * @param string $value json or xml
     * @return $this
     */
    public function setFormat($value)
    {
        return $this->setParam('format', $value);
    }

    /**
     * @return array|bool|mixed
     */
    public function getFormat()
    {
        return $this->getParam('format');
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
     * @return $this
     */
    protected function setDefaultParams()
    {
        $params = [
            'timestamp' => date('Y-m-d H:i:s', time()),
            'format' => self::FORMAT_JSON,
            'v' => self::VERSION,
            'sign_method' => self::SIGN_METHOD_MD5,
        ];

        return $this->setParams($params);
    }

    /**
     * @param BaseRequest $request
     * @return ErrorResponse|SuccessResponse
     * @throws \cdcchen\net\curl\RequestException
     */
    public function execute(BaseRequest $request)
    {
        $request->beforeExecute();

        $this->_params = array_merge($this->_params, $request->getParams());

        $this->prepare();
        $response = CUrlClient::post($this->_restUrl, $this->_params)->send();
        return $this->afterExecute($request, $response);
    }

    /**
     * @param BaseRequest $request
     * @param CurlResponse $response
     * @return \cdcchen\alidayu\SuccessResponse | ErrorResponse
     */
    protected function afterExecute(BaseRequest $request, CurlResponse $response)
    {
        $data = $this->parseContent($response->getContent());
        if (isset($data['code'])) {
            return new ErrorResponse($data);
        } else {
            $className = $request->getResponseClass();
            return new $className($data);
        }
    }

    /**
     * @param string $content
     * @return array|bool|mixed
     */
    protected function parseContent($content)
    {
        if ($this->getFormat() === self::FORMAT_JSON) {
            return static::jsonParse($content);
        } elseif ($this->getFormat() === self::FORMAT_XML) {
            return static::xmlParse($content);
        } else {
            return false;
        }
    }

    /**
     * @param string $content
     * @return mixed
     * @throws \ErrorException
     */
    protected static function jsonParse($content)
    {
        $data = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return current($data);
        } else {
            throw new \ErrorException(json_last_error_msg());
        }
    }

    /**
     * @param string $xml
     * @return array
     */
    protected static function xmlParse($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml);
        }
        $result = (array)$xml;
        foreach ($result as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $result[$key] = static::xmlParse($value);
            }
        }
        return $result;
    }

    /**
     * prepare for execute
     */
    private function prepare()
    {
        $this->checkAppKeySecret();
        $this->checkRequireParams();

        $sign = $this->generateSign();
        $this->setParam('sign', $sign);
    }

    /**
     * Check appKey and appSecret
     */
    private function checkAppKeySecret()
    {
        if (empty($this->_appKey) || empty($this->_secret)) {
            throw new \InvalidArgumentException('Appkey and secret is required.');
        }
    }

    /**
     * Check require params
     */
    private function checkRequireParams()
    {
        $requireParams = $this->getRequireParams();

        foreach ($requireParams as $param) {
            if (!isset($this->_params[$param])) {
                throw new \InvalidArgumentException("$param is required.");
            }
        }
    }

    /**
     * @return array
     */
    protected static function getRequireParams()
    {
        return ['method', 'app_key', 'timestamp', 'v', 'sign_method'];
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

}