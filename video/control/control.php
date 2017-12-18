<?php
/**
 * Created by PhpStorm.
 * User: 神秘大腿
 * Date: 2017/3/18
 * Time: 10:15
 * QQ:  997823131 
 */
class BaseAgent {
    public function __construct(){
            /* 判断当前用户的具体权限 start */

            /*if(!$_SESSION['is_agent_login']){
                redirect(AGENT_SITE_URL.DS."index.php?act=user&op=login");
//                ajaxReturn(array('state'=>0,'msg'=>'请登录'));
                exit;
            }*/

        define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.DS."templates".DS."default");
            /* 判断当前用户的具体权限 end */
        //转码  防止GBK下用ajax调用时传汉字数据出现乱码
        if (($_GET['branch']!='' || $_GET['op']=='ajax') && strtoupper(CHARSET) == 'GBK'){
            $_GET = Language::getGBK($_GET);
        }
        Tpl::setLayout("common_layout");
        Tpl::setDir('home');
    }

}
class BaseManger extends BaseAgent{
    public function __construct(){
        parent::__construct();
        define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.DS."templates".DS."default");

        //转码  防止GBK下用ajax调用时传汉字数据出现乱码
        if (($_GET['branch']!='' || $_GET['op']=='ajax') && strtoupper(CHARSET) == 'GBK'){
            $_GET = Language::getGBK($_GET);
        }

        Tpl::setLayout("common_layout");
        Tpl::setDir('home');
    }
}
class BaseUser {
    public function __construct(){
        define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.DS."templates".DS."default");

        //转码  防止GBK下用ajax调用时传汉字数据出现乱码
        if (($_GET['branch']!='' || $_GET['op']=='ajax') && strtoupper(CHARSET) == 'GBK'){
            $_GET = Language::getGBK($_GET);
        }

        Tpl::setLayout("common_layout");
        Tpl::setDir('home');
    }
}