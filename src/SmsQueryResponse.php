<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/14
 * Time: 14:50
 */

namespace cdcchen\alidayu;


/**
 * Class SmsQueryResponse
 * @package cdcchen\alidayu
 */
class SmsQueryResponse extends SuccessResponse
{
    /**
     * @return int|null
     */
    public function getTotalCount()
    {
        return $this->get('total_count');
    }

    /**
     * @return int|null
     */
    public function getTotalPage()
    {
        return $this->get('total_page');
    }

    /**
     * @return mixed|null
     */
    public function getValues()
    {
        return $this->get('values');
    }

    /**
     * @return null|SmsLogItem[]
     */
    public function getItems()
    {
        $values = $this->getValues();
        if ($values && isset($values['fc_partner_sms_detail_dto'])) {
            $items = $values['fc_partner_sms_detail_dto'];
            foreach ($items as $index => $item) {
                $items[$index] = new SmsLogItem($item);
            }

            return $items;
        } else {
            return null;
        }
    }
}