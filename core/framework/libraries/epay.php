<?php
/**
 * Created by PhpStorm.
 * User: 神秘大腿
 * Date: 2017/2/8
 * Time: 8:33
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');
// 双乾支付   // 传值时大小写必须区分
class Epay {
    public $MerNo 	= "200011";  // 商户ID 固定
    public $MD5key  = "C!nftXxo";   // 商户KEY 固定
    public $Amount 	= 0.01;         //订单金额  变量  必须
    public $BillNo ;            // 订单号 变量
    public $subject = "app的subject";        // 扫码付款时 才有的参数   订单主题 变量
    public $desc = "subject的desc";          // 扫码付款时 才有的参数   订单主题描述 变量

    public $ReturnURL = "http://139.224.206.189/index.php?act=pay_return"; // 银行付款时才有的参数 回调地址
    public $MD5info ;      // 签证

    public $NotifyURL = "http://139.224.206.189/index.php?act=pay_return&op=codepay";  // 扫码 与 银行 付款都有的参数 变量
    public $PaymentType = "WXZF"; //wxzf  zfbzf         // 支付公司  银行：工商 农行 邮政 建行  扫码：支付宝 微信  变量
    public $PayType = "SMZF";//CSPAY:网银支付;          // 支付渠道  网银支付  扫码支付     变量

    public function __construct($arr){  // 传值时大小写必须区分
              //  print_r(get_class_vars(get_class($this)));
            foreach($arr as $key=>$val){
                if(array_key_exists($key,get_class_vars(get_class($this)))){
                    echo $val.'<br>';
                    $this->$key = $val;
                }else{
                    echo $key.'不在<br>';
                }
            }
            $this->BillNo = "1688888888".time();
            $this->MD5info = $this->getSignature($this->MerNo, $this->BillNo, $this->Amount, $this->ReturnURL, $this->MD5key);
    }
    // 生成表单信息
    public function createPayForm($type){
            // type 网银支付CSPAY  扫码支付SMZF


    }

// 获取签证信息
    private function getSignature($MerNo, $BillNo, $Amount, $ReturnURL, $MD5key){
        $_SESSION['MerNo'] = $MerNo;
        $_SESSION['MD5key'] = $MD5key;
        $sign_params  = array(
            'MerNo'       => $MerNo,
            'BillNo'       => $BillNo,
            'Amount'         => $Amount,
            'ReturnURL'       => $ReturnURL
        );
        $sign_str = "";
        ksort($sign_params);
        foreach ($sign_params as $key => $val) {
            $sign_str .= sprintf("%s=%s&", $key, $val);
        }
        print $sign_str;print '<br/><br/><br/>';
        return strtoupper(md5($sign_str. strtoupper(md5($MD5key))));
    }

}