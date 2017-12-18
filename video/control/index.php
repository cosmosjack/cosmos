<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/4/14
 * Time: 15:58
 * QQ:  997823131 
 */
require BASE_ROOT_PATH.DS.'vendor'.DS."autoload.php";
use QL\QueryList;
use EXAMPLE\Test;
use Qiniu;

class indexControl extends BaseManger{
    public function __construct(){
        parent::__construct();
    }
    public function indexOp(){
       $test = C('db.master');
        print_r($test) ;
        $slave = C('db.slave');
        print_r($slave);
        echo '<br>';
        echo '<hr>';
//       P($GLOBALS['setting_config']) ;
    }
    // 员工个人主页
    public function userinfoOp(){
        /* 查询会员的所有信息 start */

        /* 查询会员的所有信息 end */

        Tpl::showpage('user_info');
    }
    // 添加员工界面
    public function adduserOp(){
        Tpl::showpage('add_user');
    }
    // 员工列表
    public function userlistOp(){
        Tpl::showpage('user_list');
    }
    //角色添加
    public function add_roleOp(){
        Tpl::showpage("add_role");
    }
    // 权限分配
    public function authorityOp(){
        Tpl::showpage('authority');
    }
    // 商品类别
    public function goods_clsOp(){
        Tpl::showpage('goods_cls');
    }
    // 添加类别
    public function add_clsOp(){
        Tpl::showpage("add_cls");
    }
    // 添加商品
    public function goods_addOp(){
        Tpl::showpage('goods_add');
    }
    //商品列表
    public function goods_listOp(){
        Tpl::showpage('goods_list');
    }
    // 广告列表
    public function adv_listOp(){
        $lang = Language::getLangContent();
        $adv  = Model('adv');
        /**
         * 多选删除广告位
         */
        if (chksubmit()){
            if (!empty($_POST['del_id'])){
                $in_array_id=implode(',',$_POST['del_id']);
                $where  = "where ap_id in (".$in_array_id.")";
                Db::delete("adv_position",$where);
                foreach ($_POST['del_id'] as $v) {
                    $adv->delapcache($v);
                }
            }
            $url = array(
                array(
                    'url'=>trim($_POST['ref_url']),
                    'msg'=>$lang['goback_ap_manage'],
                )
            );
            $this->log(L('ap_del_succ').'[ID:'.$in_array_id.']',null);
            showMessage($lang['ap_del_succ'],$url);
        }
        /**
         * 显示广告位管理界面
         */
        $condition = array();
        $orderby   = '';
        if($_GET['search_name'] != ''){
            $condition['ap_name'] = trim($_GET['search_name']);
        }
        /**
         * 分页
         */
        $page	 = new Page();
        $page->setEachNum(25);
        $page->setStyle('admin');

        $ap_list  = $adv->getApList($condition,$page,$orderby);
        $adv_list = $adv->getList();
        Tpl::output('ap_list',$ap_list);
        Tpl::output('adv_list',$adv_list);
        Tpl::output('page',$page->show());
        Tpl::showpage('ap_manage');
    }
    //广告费用统计
    public function adv_freeOp(){
        Tpl::showpage('adv_free');
    }
    // 内部资料列表
    public function materialOp(){
        define(MATERIAL_PATH,$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."ueditor".DIRECTORY_SEPARATOR."php".DIRECTORY_SEPARATOR."upload");
//        P(MATERIAL_PATH);
        $file_list = array();
        readFileList(MATERIAL_PATH,$file_list,array());

        // 需要 文件名字 文件全路径  文件 从 upload 后边开始的名字
        for($i=0;$i<count($file_list);$i++){
            $file_name[$i] = basename($file_list[$i]);
            $file_url[$i] = strpos($file_list[$i],"upload");
            $file_url[$i] = BASE_SITE_URL.DIRECTORY_SEPARATOR."ueditor".DIRECTORY_SEPARATOR."php".DIRECTORY_SEPARATOR.substr($file_list[$i],$file_url[$i]);
            $material_data[$i]['file_path'] = $file_list[$i];
            $material_data[$i]['file_name'] = $file_name[$i];
            $material_data[$i]['file_url'] = $file_url[$i];
            $temp_name = explode('.',$file_name[$i]);
            $temp_num = count($temp_name);
            $material_data[$i]['suffixes'] = $temp_name[$temp_num-1];
        }
//       P($material_data);
        Tpl::output('material_data',$material_data);
        $file_path = BASE_DATA_PATH.DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."test.xlsx";
//        $objReader = new PHPExcel_Reader_Excel5();

        /* 这是Excel 的输出 start */
//        $objReader =new PHPExcel_Reader_Excel2007();
//        P($objReader);
//        die;
//        $objWriteHtml = new PHPExcel_Writer_HTML($objReader->load($file_list[0]));
//        P($objWriteHtml);
//        echo $objWriteHtml->save("php://output");
        /* 这是Excel 的输出 end */

        /* word 的输出 start */
//        $wordRead = new \PhpOffice\PhpWord\Reader\Word2007();
////        P($wordRead);
//        $wordHtml = new PhpOffice\PhpWord\Writer\HTML($wordRead->load($file_list[2]));
////        P($wordHtml);
//        echo $wordHtml->save("php://output");
        /* word 的输出 end */
        Tpl::showpage('material');
    }
    // 展示具体的文档
    public function material_showOp(){
//        P($_GET['file_path']);
        if($_GET['suffixes'] == 'docx'){
//            echo 'docx';
            $wordRead = new \PhpOffice\PhpWord\Reader\Word2007();
//        P($wordRead);
            $wordHtml = new PhpOffice\PhpWord\Writer\HTML($wordRead->load($_GET['file_path']));
//        $wordHtml = new PhpOffice\PhpWord\Writer\HTML\Element\Text('dd');
//        $wordHtml->setWithoutP(true);
//        $wordHtml = new \PhpOffice\PhpWord\Writer\Word2007($wordRead->load($file_list[2]));
//        P($wordHtml);
            echo $wordHtml->save("php://output");
        }elseif($_GET['suffixes'] == 'xlsx'){
//            echo 'xlsx';
            $objReader =new PHPExcel_Reader_Excel2007();
//            P($objReader);
//            die;
            $objWriteHtml = new PHPExcel_Writer_HTML($objReader->load($_GET['file_path']));
//            P($objWriteHtml);
        echo $objWriteHtml->save("php://output");
        }else{
            echo '<h1 align="center">没有此文件</h1>';
        }
        Tpl::showpage('material_show');
    }
    // 内部资料管理
    public function material_mangerOp(){
        Tpl::showpage('material_manger');
    }
    // 店铺列表简介
    public function store_listOp(){

        Tpl::showpage('store_list');
    }
    // 推送公告
    public function pushMessageOp(){

        Tpl::showpage('push_message');
    }
    // 修改自己的资料
    public function modMyInfoOp(){
        if(isset($_POST['sub'])){
//            P($_POST);
            $db_agent_user = new Dpdo();
            $db_agent_user->setTable('agent_user');
            $result = $db_agent_user->where(array('id'=>$_SESSION['agent_user']['id']))->update($_POST);
            if($result){
                $data_agent_user = $db_agent_user->where(array('id'=>$_SESSION['agent_user']['id']))->find();
//                P($data_agent_user);
                $_SESSION['agent_user'] = $data_agent_user;
//                P($_SESSION);
                goto jack;
            }else{
                goto jack;
            }
        }else{
            /* 獲取自己的信息 start */
//            P($_SESSION['agent_user']);
            jack:
            $area_info = explode("|",$_SESSION['agent_user']['area_name']);

            Tpl::output('area_info',$area_info);
            Tpl::output('agent_info',$_SESSION['agent_user']);
            $avatar = UPLOAD_SITE_URL.DS."agent".DS.$_SESSION['agent_user']['avatar'];
//            P($_SESSION['agent_user']);
            Tpl::output('avatar',$avatar);
            /* 獲取自己的信息 end */
        }
        Tpl::showpage('modMyInfo');
    }
    /* 修改头像 start */
    public function mod_avatarOp(){
        $up = new Upload(array('upload_path'=>"/agent/"));
        $result = $up->upload_File('avatar');
        if(is_file($result["filePathName"][0])){
            $image = new Image(BASE_UPLOAD_PATH.DS."agent".DS);
            $th_avatar = $image->thumb($result['fileNewName'][0],64,64);
//            P($th_avatar);
            if(is_file(BASE_UPLOAD_PATH.DS."agent".DS.$th_avatar)){
                @unlink($result["filePathName"][0]);
            }
            $update['avatar'] = $th_avatar;
            $db_agent_user = new Dpdo();
            $db_agent_user->setTable('agent_user');

            $result_db = $db_agent_user->where(array('id'=>$_SESSION['agent_user']['id']))->update($update);
            if($result_db){

                @unlink(BASE_UPLOAD_PATH.DS."agent".DS.$_SESSION['agent_user']['avatar']);
                $_SESSION['agent_user']['avatar'] = $th_avatar;
            }
            ajaxReturn(UPLOAD_SITE_URL.DS."agent".DS.$th_avatar);
        }else{
            ajaxReturn(UPLOAD_SITE_URL.DS."agent".DS."logo.png");
        }

    }
    /* 修改头像 end */
    /* 修改自己的密码 start */
    public function mod_my_passwdOp(){
        $db_user = new Dpdo();
        $db_user->setTable('agent_user');
        $data_user = $db_user
            ->where(array('id'=>$_SESSION['agent_user']['id'],'passwd'=>md5($_POST['old_passwd'])))
            ->find();
        if($data_user){
//            echo '匹配';
            if($_POST['new_passwd'] === $_POST['re_passwd']){
//                echo '两次密码相等';
                $update['passwd'] = md5($_POST['new_passwd']);
                $result = $db_user->where(array('id'=>$_SESSION['agent_user']['id']))->update($update);
                if($result){
//                    echo '修改成功';
                    ajaxReturn(array('control'=>'mod_my_passwdOp','code'=>200,'msg'=>'修改成功'),"JSON");
                }else{
//                    echo '修改不成功';
                    ajaxReturn(array('control'=>'mod_my_passwdOp','code'=>0,'msg'=>'修改不成功',$_POST),"JSON");
                }
            }else{
//                echo '两次密码不相等';
                ajaxReturn(array('control'=>'mod_my_passwdOp','code'=>0,'msg'=>'两次密码不相等',$_POST),"JSON");

            }
        }else{
//            echo '账号密码不匹配';
            ajaxReturn(array('control'=>'mod_my_passwdOp','code'=>0,'msg'=>'账号密码不匹配',$_POST),"JSON");

        }
    }
    /* 修改自己的密码 end */

    /* 驗證是否登錄 start */
    private function is_login(){
        $db_mb_token = new Dpdo();
        $db_mb_token->setTable('mb_user_token');
        $data_mb_token = $db_mb_token->where(array('token'=>$_REQUEST['key']))->find();
        return $data_mb_token;
    }
    /* 驗證是否登錄 end */


}