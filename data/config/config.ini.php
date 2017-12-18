<?php


$config = array();
$config['base_site_url'] 		= 'http://framework.net';
$config['shop_site_url'] 		= 'http://framework.net/shop';
$config['cms_site_url'] 		= 'http://framework.net/cms';
$config['microshop_site_url'] 	= 'http://framework.net/microshop';
$config['circle_site_url'] 		= 'http://framework.net/circle';
$config['agent_site_url']       = 'http://framework.net/agent';// A平台
$config['admin_site_url'] 		= 'http://framework.net/admin';
$config['mobile_site_url'] 		= 'http://framework.net/mobile';
$config['wap_site_url'] 		= 'http://framework.net/wap';
$config['chat_site_url'] 		= 'http://framework.net/chat';
$config['node_site_url'] 		= 'http://192.168.1.220:3000';
$config['delivery_site_url']    = 'http://framework.net/delivery';
$config['upload_site_url']		= 'http://framework.net/data/upload';
$config['resource_site_url']	= 'http://framework.net/data/resource';
$config['indiana_site_url']	= 'http://framework.net/indiana';

$config['version'] 		= '201601130001';
$config['setup_date'] 	= '2016-12-22 11:26:17';
$config['gip'] 			= 0;
$config['dbdriver'] 	= 'mysqli';
$config['tablepre']		= '33hao_';  //表前缀
$config['db']['1']['dbhost']       = 'localhost';
$config['db']['1']['dbport']       = '3306';
$config['db']['1']['dbuser']       = 'root';
$config['db']['1']['dbpwd']        = 'root';
$config['db']['1']['dbname']       = '33hao';
$config['db']['1']['dbcharset']    = 'UTF-8';

$config['db']['slave']['dbhost']       = '192.168.2.11';
$config['db']['slave']['dbport']       = '3306';
$config['db']['slave']['dbuser']       = 'fuxuan';
$config['db']['slave']['dbpwd']        = '123456';
$config['db']['slave']['dbname']       = '33hao';
$config['db']['slave']['dbcharset']    = 'UTF-8';
//$config['db']['slave']             = $config['db']['master'];
$config['session_expire'] 	= 3600; //回话过期时间 3600毫秒
$config['lang_type'] 		= 'zh_cn';
$config['cookie_pre'] 		= 'B847_';  //cookie 前缀
$config['thumb']['cut_type'] = 'gd';
$config['thumb']['impath'] = '';
$config['cache']['type'] 			= 'file';
//$config['redis']['prefix']      	= 'nc_';
//$config['redis']['master']['port']     	= 6379;
//$config['redis']['master']['host']     	= '127.0.0.1';
//$config['redis']['master']['pconnect'] 	= 0;
//$config['redis']['slave']      	    = array();
//$config['fullindexer']['open']      = false;
//$config['fullindexer']['appname']   = '33hao';
$config['debug'] 			= false;
$config['default_store_id'] = '1';
$config['url_model'] = false;  //URL 类型
$config['subdomain_suffix'] = '';
//$config['session_type'] = 'redis';
//$config['session_save_path'] = 'tcp://127.0.0.1:6379';
$config['node_chat'] = true;
//流量记录表数量，为1~10之间的数字，默认为3，数字设置完成后请不要轻易修改，否则可能造成流量统计功能数据错误
$config['flowstat_tablenum'] = 3;
$config['sms']['gwUrl'] = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService';
$config['sms']['serialNumber'] = '';
$config['sms']['password'] = '';
$config['sms']['sessionKey'] = '';
$config['queue']['open'] = false;
$config['queue']['host'] = '127.0.0.1';
$config['queue']['port'] = 6379;
$config['cache_open'] = false;
$config['delivery_site_url']    = 'http://framework.net/delivery';
return $config;