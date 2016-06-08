<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/7
 * Time: 20:09
 */

namespace cdcchen\alidayu;

use cdcchen\net\curl\Response as CurlResponse;


/**
 * Class SmsClient
 * @package cdcchen\alidayu
 */
class SmsSendClient extends BaseClient
{
    public $method = 'alibaba.aliqin.fc.sms.num.send';

    /**
     * @param $value
     * @return $this
     */
    public function setSmsType($value)
    {
        return $this->setParam('sms_type', $value);
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSmsFreeSignName($value)
    {
        return $this->setParam('sms_free_sign_name', $value);
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSmsTemplateCode($value)
    {
        return $this->setParam('sms_template_code', $value);
    }

    /**
     * @param $value
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
     * @param $value
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
     * @param $value
     * @return $this
     */
    public function setExtend($value)
    {
        return $this->setParam('extend', $value);
    }

    protected function getRequireParams()
    {
        return ['sms_type', 'sms_free_sign_name', 'rec_num', 'sms_template_code'];
    }

    protected function buildSuccessResponse(CurlResponse $response)
    {
        $data = json_decode($response->getContent(), true);

        $result = $data['alibaba_aliqin_fc_sms_num_send_response']['result'];
        $result['request_id'] = $data['alibaba_aliqin_fc_sms_num_send_response']['request_id'];

        return new Response($result);
    }


}