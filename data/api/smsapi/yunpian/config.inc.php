<?php
defined('InCosmos') or exit('Access Invalid!');
/*
 * 配置文件
 */
$options = array();
$options['apikey'] = C('mobile_key'); //apikey
$options['signature'] =  C('mobile_signature'); //签名
return $options;
?>