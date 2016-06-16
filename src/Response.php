<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/8
 * Time: 09:59
 */

namespace cdcchen\alidayu;


/**
 * Class Response
 * @package cdcchen\alidayu
 */
class Response extends BaseResponse
{
    /**
     * @return string|null
     */
    public function getRequestId()
    {
        return $this->get('request_id');
    }
}