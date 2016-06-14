<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/7
 * Time: 20:09
 */

namespace cdcchen\alidayu;


/**
 * Class SmsClient
 * @package cdcchen\alidayu
 */
class SmsSendClient extends BaseClient
{
    /**
     * @var string
     */
    public $method = 'alibaba.aliqin.fc.sms.num.send';

    public function init()
    {
        parent::init();
        $this->setSmsType('normal');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSmsType($value)
    {
        return $this->setParam('sms_type', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSmsFreeSignName($value)
    {
        return $this->setParam('sms_free_sign_name', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSmsTemplateCode($value)
    {
        return $this->setParam('sms_template_code', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setReceiveNumber($value)
    {
        if (is_array($value)) {
            if (count($value) > 200) {
                throw new \InvalidArgumentException('The maximum of receive phone number is 200.');
            }
            $value = join(',', $value);
        }
        return $this->setParam('rec_num', $value);
    }

    /**
     * @param array|string $value
     * @return $this
     */
    public function setSmsParams($value)
    {
        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return $this->setParam('sms_param', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setExtend($value)
    {
        return $this->setParam('extend', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['sms_type', 'sms_free_sign_name', 'rec_num', 'sms_template_code'];
    }

    /**
     * @param array $data
     * @return SuccessResponse
     */
    protected function afterResponse(array $data)
    {
        $result = $data['result'];
        $result['request_id'] = $data['request_id'];

        return new SuccessResponse($result);
    }

}