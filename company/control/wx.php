<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/8/22
 * Time: 9:45
 * QQ:  997823131 
 */
class wxControl extends BaseUser{
    public function __construct(){
        parent::__construct();
    }

    public function get_wx_openidOp(){

        $appid = "wx76f323fa386627e7";
        $appsecret = "dd198d8a7a412c51fd094faca669a3b4"; //b8613253cce45d00fbd1aeb56fbd5725 //3564b4ba8419790cc0d2f523e0d0a9f9
        $code = $_GET["code"];
        $get_accessUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$_GET['code']."&grant_type=authorization_code";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_accessUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($output, true);
//  ajaxReturn($jsoninfo,'JSONP');

//        echo '<meta charset="UTF-8">';
//        echo '<pre>';
//        print_r($json_obj);
//        echo '</pre>';

        /* 进入下一步 确认用户信息 要求输出 账号和密码 start */
        $_SESSION['openid'] = $json_obj['openid'];
        if(!$_SESSION['openid']){
            echo '授权失败';
            exit;
        }
        Tpl::output('openid',$json_obj['openid']);
        Tpl::showpage("wx_binding");
        /* 进入下一步 确认用户信息 要求输出 账号和密码 end */
    }
    public function bindingOp(){
        P();
        if(isset($_POST['sub']) && $_POST['sub'] == 'ok'){
            // 验证
            $return_code = checkSeccode($_POST['nchash'],$_POST['code']);
            if($return_code){
//                echo '验证成功';
                $db_member = new Dpdo();
                $db_member->setTable('member');
                $data_member = $db_member
                    ->where(
                        array('member_name'=>$_POST['user_name']),
                        array('member_email'=>$_POST['user_name']),
                        array('member_mobile'=>$_POST['user_name'])
                    )
                    ->find();
                if($data_member){
                    $db_member_wx = new Dpdo();
                    $db_member_wx->setTable('member_wx');
                    /* 判断此会员是否 被绑定过 start */
                    $result_member = $db_member_wx->where(array('member_id'=>$data_member['member_id']))->find();
                    if($result_member){
//                        echo '有绑定过';
                        showMessage('此会员已被其他人绑定',AGENT_SITE_URL.'/index.php?act=carry&op=binding','html','error');
                        exit;
                    }
                    /* 判断此会员是否 被绑定过 end */

                    if($data_member['member_passwd'] == md5($_POST['user_passwd'])){
//                        echo '密码正确';
                        /* 开始绑定  start */

                        $insert['member_id'] = $data_member['member_id'];
                        $insert['member_name'] = $data_member['member_name'];
                        $insert['wx_openid'] = $_SESSION['openid'];
                        $insert['add_time'] = time();
                        $result = $db_member_wx->insert($insert);
                        if($result){
//                            $_SESSION['agent_user']['member_id'] = $update['member_id'];
//                            echo '绑定成功';
//                            ajaxReturn(array('control'=>'binding','code'=>200,'msg'=>'绑定成功'),"JSON");

                            showMessage('绑定成功,请在PC端重新登录',AGENT_SITE_URL.'/index.php?act=carry&op=index','html','succ');
                        }else{
//                            echo '绑定失败';
//                            ajaxReturn(array('control'=>'binding','code'=>0,'msg'=>'绑定失败'),"JSON");
                            showMessage('绑定失败','','html','error');

                        }
                        /* 开始绑定  end */
                    }else{
//                        echo '密码不对';
//                        ajaxReturn(array('control'=>'binding','code'=>0,'msg'=>'密码不对'),"JSON");
                        showMessage('密码不对','','html','error');
                    }
                }else{
//                    echo '没有这个用户';
//                    ajaxReturn(array('control'=>'binding','code'=>0,'msg'=>'没有这个用户'),"JSON");
                    showMessage('没有这个用户','','html','error');

                }
            }else{
//                echo '验证失败';
//                ajaxReturn(array('control'=>'binding','code'=>0,'msg'=>'验证失败'),"JSON");
                showMessage('验证失败','','html','error');

            }
        }else{
            Tpl::showpage("wx_binding");
        }
    }
    public function testOp(){
        Tpl::showpage("wx_binding");
    }
}