<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/4/18
 * Time: 16:47
 * QQ:  997823131 
 */
//echo $_SERVER['DOCUMENT_ROOT'].DS.'autoload.php';
require $_SERVER['DOCUMENT_ROOT'].DS.'autoload.php';


use JPush\Client as JPush;

//echo 'ddd';
//die;
/*$app_key = getenv('050664198e9b37cd7cbe4346');
$master_secret = getenv('22376f850f0ee02129dbb6bc');
$registration_id = getenv('');*/
$app_key = '050664198e9b37cd7cbe4346';
$master_secret = '22376f850f0ee02129dbb6bc';

$client = new JPush($app_key, $master_secret);
