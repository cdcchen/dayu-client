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
class SmsQueryClient extends BaseClient
{
    public $method = 'alibaba.aliqin.fc.sms.num.query';

    public function setBizId($id)
    {
        $this->setParam('biz_id', $id);
        return $this;
    }

    public function setQueryDate($value)
    {
        $this->setParam('query_date', $value);
        return $this;
    }

    public function setCurrentPage($value)
    {
        $this->setParam('current_page', $value);
        return $this;
    }

    public function setPageSize($value)
    {
        $this->setParam('page_size', $value);
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setReceiveNumber($value)
    {
        return $this->setParam('rec_num', $value);
    }

    protected function getRequireParams()
    {
        return ['rec_num', 'query_date', 'current_page', 'page_size'];
    }

    protected function buildSuccessResponse(CurlResponse $response)
    {
        $data = json_decode($response->getContent(), true);
        $result = $data['alibaba_aliqin_fc_sms_num_query_response'];
        if (isset($result['values'])) {
            $result['values'] = $result['values']['fc_partner_sms_detail_dto'];
        }

        return new Response($result);
    }


}