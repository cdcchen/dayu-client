<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/14
 * Time: 13:42
 */

namespace cdcchen\alidayu;


/**
 * Class SmsLogItem
 * @package cdcchen\alidayu
 */
class SmsLogItem extends Object
{
    /**
     * 等待回执
     */
    const STATUS_WAIT_RECEIPT = 1;
    /**
     * 失败
     */
    const STATUS_ERROR   = 2;
    /**
     * 成功
     */
    const STATUS_SUCCESS = 3;

    /**
     * @var string
     */
    public $extend;
    /**
     * @var string
     */
    public $receiveNumber;
    /**
     * @var string
     */
    public $resultCode;
    /**
     * @var string
     */
    public $templateCode;
    /**
     * @var string
     */
    public $content;
    /**
     * @var string
     */
    public $receiveTime;
    /**
     * @var string
     */
    public $sendTime;
    /**
     * @var int
     */
    public $status;

    /**
     * SmsLogItem constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->extend = $data['extend'];
        $this->receiveNumber = $data['rec_num'];
        $this->resultCode = $data['result_code'];
        $this->templateCode = $data['sms_code'];
        $this->content = $data['sms_content'];
        $this->receiveTime = $data['sms_receiver_time'];
        $this->sendTime = $data['sms_send_time'];
        $this->status = $data['sms_status'];
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->status == self::STATUS_ERROR;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status == self::STATUS_SUCCESS;
    }

    /**
     * @return bool
     */
    public function isWaitReceipt()
    {
        return $this->status == self::STATUS_WAIT_RECEIPT;
    }
}