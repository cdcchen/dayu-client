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
class SuccessResponse extends BaseResponse
{
    /**
     * @return bool
     */
    public function isOK()
    {
        return true;
    }
}