<?php
define('APP_ID','video');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/cosmos.php')) exit('cosmos.php isn\'t exists!');

if (!@include(BASE_PATH.'/config/config.ini.php')){
    @header("Location: install/index.php");die;
}

define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/default');
define('APP_SITE_URL',COMPANY_SITE_URL);
define('TPL_NAME', 'default');
define('COMPANY_TEMPLATES_URL', COMPANY_SITE_URL.'/templates/default');
define('COMPANY_RESOURCE_SITE_URL',COMPANY_SITE_URL.'/resource');

//echo BASE_PATH;
require(BASE_PATH.'/framework/function/function.php');
require(BASE_PATH.'/control/control.php');
Base::run();