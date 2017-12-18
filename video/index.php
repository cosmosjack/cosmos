<?php
/**
 * Created by PhpStorm.
 * User: 神秘大腿
 * Date: 2017/3/18
 * Time: 10:09
 * QQ:  997823131 
 */
/*function loadprint( $class ) {
    $file = $class . '.php';
    echo 'ddd';
    if (is_file($file)) {
        echo $file;
        require_once($file);
    }
}

spl_autoload_register('loadprint');

$app_key = '050664198e9b37cd7cbe4346';
$master_secret = '22376f850f0ee02129dbb6bc';
$client = new Client($app_key, $master_secret);
print_r($client);
die;*/

define('APP_ID','video');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/cosmos.php')) exit('cosmos.php isn\'t exists!');

if (!@include(BASE_PATH.'/config/config.ini.php')){
    @header("Location: install/index.php");die;
}

define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/default');
define('APP_SITE_URL',VIDEO_SITE_URL);
define('TPL_NAME', 'default');
define('AGENT_TEMPLATES_URL', AGENT_SITE_URL.'/templates/default');
define('AGENT_RESOURCE_SITE_URL',AGENT_SITE_URL.'/resource');
//echo BASE_PATH;
require(BASE_PATH.'/framework/function/function.php');
require(BASE_PATH.'/control/control.php');
Base::run();