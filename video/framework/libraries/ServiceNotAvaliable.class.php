<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/4/19
 * Time: 10:49
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');
class ServiceNotAvaliableClass extends JPushExceptionClass {

    private $http_code;
    private $headers;

    function __construct($response){
        $this->http_code = $response['http_code'];
        $this->headers = $response['headers'];
        $this->message = $response['body'];
    }

    function __toString() {
        return "\n" . __CLASS__ . " -- [{$this->http_code}]: {$this->message} \n";
    }

    public function getHttpCode() {
        return $this->http_code;
    }
    public function getHeaders() {
        return $this->headers;
    }
}
