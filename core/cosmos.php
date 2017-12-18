<?php
defined('InCosmos') or exit('Access Invalid!');
//定义CONFIG
if (!@include(BASE_DATA_PATH.'/config/config.ini.php')) exit('config.ini.php isn\'t exists!');
//根目录 的config下的config文件 一般是没有的
if (file_exists(BASE_PATH.'/config/config.ini.php')){
	include(BASE_PATH.'/config/config.ini.php');
}
global $config;
//echo '<pre>';
//print_r($config);
//echo '</pre>';
//默认平台店铺id
define('DEFAULT_PLATFORM_STORE_ID', $config['default_store_id']);

define('URL_MODEL',$config['url_model']);  //false
$auto_site_url = strtolower('http://'.$_SERVER['HTTP_HOST'].implode('/',$tmp_array));
define(SUBDOMAIN_SUFFIX, $config['subdomain_suffix']);  // '' 域名 后缀

define('BASE_SITE_URL', $config['base_site_url']);
define('SHOP_SITE_URL', $config['shop_site_url']);
define('CMS_SITE_URL', $config['cms_site_url']);
define('CIRCLE_SITE_URL', $config['circle_site_url']);
define('AGENT_SITE_URL', $config['agent_site_url']);// A 平台
define('VIDEO_SITE_URL', $config['video_site_url']);// 视频
define('INDIANA_SITE_URL', $config['indiana_site_url']); // 夺宝
define('MICROSHOP_SITE_URL', $config['microshop_site_url']);
define('ADMIN_SITE_URL', $config['admin_site_url']);
define('MOBILE_SITE_URL', $config['mobile_site_url']);
define('WAP_SITE_URL', $config['wap_site_url']);
define('UPLOAD_SITE_URL',$config['upload_site_url']);
define('RESOURCE_SITE_URL',$config['resource_site_url']);
define('DELIVERY_SITE_URL',$config['delivery_site_url']);
define('CHAT_SITE_URL', $config['chat_site_url']);
define('NODE_SITE_URL', $config['node_site_url']);
define('UPLOAD_SITE_URL_HTTPS', $config['upload_site_url']);

define('BASE_DATA_PATH',BASE_ROOT_PATH.'/data');  // 数据 目录
define('BASE_UPLOAD_PATH',BASE_DATA_PATH.'/upload');    //上传目录
define('BASE_RESOURCE_PATH',BASE_DATA_PATH.'/resource');    //资源目录
define('ATTACH_GOODS_CLASS','shop/goods_class');    //固定 商品 类

define('RESOURCE_SITE_URL_HTTPS',$config['resource_site_url']);
define('UPLOAD_SITE_URL_HTTPS', $config['upload_site_url']);
define('LOGIN_SITE_URL',$config['member_site_url']);
define('MEMBER_SITE_URL', $config['member_site_url']);
define('CHAT_SITE_URL', $config['chat_site_url']);
define('NODE_SITE_URL', $config['node_site_url']);

define('CHARSET',$config['db'][1]['dbcharset']);  //UTF-8
define('DBDRIVER',$config['dbdriver']);  //mysqli
define('SESSION_EXPIRE',$config['session_expire']);
define('LANG_TYPE',$config['lang_type']);
define('COOKIE_PRE',$config['cookie_pre']);

//定义我的PDO
define("HOST","localhost");
define("USER","root");
define("PASS","root");
define("DBNAME","33hao");
define("TABPREFIX","33hao_");
define("DEBUG","0");

define('DBPRE',$config['tablepre']);
define('DBNAME',$config['db'][1]['dbname']);
$_GET['act'] = $_GET['act'] ? strtolower($_GET['act']) : ($_POST['act'] ? strtolower($_POST['act']) : null);  //用来判断权限
$_GET['op'] = $_GET['op'] ? strtolower($_GET['op']) : ($_POST['op'] ? strtolower($_POST['op']) : null);

//print_r($config);
if(empty($_GET['act'])){
    require_once(BASE_CORE_PATH.'/framework/core/route.php');
    new Route($config);
}
//统一ACTION
$_GET['act'] = preg_match('/^[\w]+$/i',$_GET['act']) ? $_GET['act'] : 'index';
$_GET['op'] = preg_match('/^[\w]+$/i',$_GET['op']) ? $_GET['op'] : 'index';

//对GET POST接收内容进行过滤,$ignore内的下标不被过滤
$ignore = array('article_content','pgoods_body','doc_content','content','sn_content','g_body','store_description','p_content','groupbuy_intro','remind_content','note_content','ref_url','adv_pic_url','adv_word_url','adv_slide_url','appcode','mail_content');
if (!class_exists('Security')) require(BASE_CORE_PATH.'/framework/libraries/security.php');
$_GET = !empty($_GET) ? Security::getAddslashesForInput($_GET,$ignore) : array();
$_POST = !empty($_POST) ? Security::getAddslashesForInput($_POST,$ignore) : array();
$_REQUEST = !empty($_REQUEST) ? Security::getAddslashesForInput($_REQUEST,$ignore) : array();
$_SERVER = !empty($_SERVER) ? Security::getAddSlashes($_SERVER) : array();

//启用ZIP压缩
if ($config['gzip'] == 1 && function_exists('ob_gzhandler') && $_GET['inajax'] != 1){
	ob_start('ob_gzhandler');
}else {
	ob_start();
}
require_once(BASE_CORE_PATH.'/framework/libraries/queue.php');
require_once(BASE_CORE_PATH.'/framework/function/core.php');
require_once(BASE_CORE_PATH.'/framework/core/base.php');

require_once(BASE_CORE_PATH.'/framework/function/goods.php');

if(function_exists('spl_autoload_register')) {
	spl_autoload_register(array('Base', 'autoload'));
} else {
	function __autoload($class) {
		return Base::autoload($class);
	}
}

?>
