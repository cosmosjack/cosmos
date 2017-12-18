<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/8/22
 * Time: 9:32
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');

//xml转array
 function xmlToArray($xml)
{
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}
//带上你的小秘钥来访问
 function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
{
    echo '到了访问这里';
    $str = file_get_contents('/cert/apiclient_cert.pem');
    echo $str;
    $ch = curl_init();
    //超时时间
    curl_setopt($ch,CURLOPT_TIMEOUT,$second);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    //这里设置代理，如果有的话
    //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
    //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

    //以下两种方式需选择一种
    //第一种方法，cert 与 key 分别属于两个.pem文件
    curl_setopt($ch,CURLOPT_SSLCERT,$_SERVER['DOCUMENT_ROOT'].'/wx/cert/apiclient_cert.pem');
    curl_setopt($ch,CURLOPT_SSLKEY,$_SERVER['DOCUMENT_ROOT'].'/wx/cert/apiclient_key.pem');
    curl_setopt($ch,CURLOPT_CAINFO,$_SERVER['DOCUMENT_ROOT'].'/wx/cert/rootca.pem');

    //第二种方式，两个文件合成一个.pem文件
    //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

    if( count($aHeader) >= 1 ){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    }

    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
    $data = curl_exec($ch);
    if($data){
        var_dump($data);
        curl_close($ch);
        return $data;
    }
    else {
        $error = curl_errno($ch);
        echo "errorCode:$error\n";
        curl_close($ch);
        return false;
    }
}