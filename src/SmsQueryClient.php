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
class SmsQueryClient extends BaseClient
{
    /**
     * @var string method name
     */
    public $method = 'alibaba.aliqin.fc.sms.num.query';

    public function init()
    {
        parent::init();
        $this->setPageSize(20);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setBizId($id)
    {
        $this->setParam('biz_id', $id);
        return $this;
    }

    /**
     * @param int $year
     * @param int|null $month
     * @param int|null $day
     * @return $this
     */
    public function setQueryDate($year, $month = null, $day = null)
    {
        if (empty($month) || empty($day)) {
            $date = $year;
        } else {
            $date = $year . $month . $day;
        }

        $this->setParam('query_date', $date);
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setCurrentPage($value)
    {
        $this->setParam('current_page', $value);
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setPageSize($value)
    {
        $this->setParam('page_size', $value);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setReceiveNumber($value)
    {
        return $this->setParam('rec_num', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['rec_num', 'query_date', 'current_page', 'page_size'];
    }

    /**
     * @param array $data
     * @return SuccessResponse
     */
    protected function afterResponse(array $data)
    {
        if (isset($data['values'])) {
            $data['values'] = $data['values']['fc_partner_sms_detail_dto'];
        }

        return new SuccessResponse($data);
    }


}