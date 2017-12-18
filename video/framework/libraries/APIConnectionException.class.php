<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/4/19
 * Time: 10:48
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');
class APIConnectionExceptionClass extends JPushExceptionClass {

    function __toString() {
        return "\n" . __CLASS__ . " -- {$this->message} \n";
    }
}
