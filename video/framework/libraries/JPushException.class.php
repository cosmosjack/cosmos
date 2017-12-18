<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/4/19
 * Time: 10:46
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');
class JPushExceptionClass extends Exception {

    function __construct($message) {
        parent::__construct($message);
    }
}