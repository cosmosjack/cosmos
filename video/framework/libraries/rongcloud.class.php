<?php
/**
 * 融云 Server API PHP 客户端
 * create by kitName
 * create datetime : 2016-09-05 
 * 
 * v2.0.1
 */
//include 'SendRequest.php';
//include 'methods/User.php';
//include 'methods/Message.php';
//include 'methods/Wordfilter.php';
//include 'methods/Group.php';
//include 'methods/Chatroom.php';
//include 'methods/Push.php';
//include 'methods/SMS.php';
    
class RongCloudClass
{
    /**
     * 参数初始化
     * @param $appKey
     * @param $appSecret
     * @param string $format
     */
    public function __construct($appKey, $appSecret, $format = 'json') {
        $this->SendRequest = new SendRequestClass($appKey, $appSecret, $format);
    }
    
    public function User() {
        $User = new UserClass($this->SendRequest);
        return $User;
    }
    
    public function Message() {
        $Message = new MessageClass($this->SendRequest);
        return $Message;
    }
    
    public function Wordfilter() {
        $Wordfilter = new WordfilterClass($this->SendRequest);
        return $Wordfilter;
    }
    
    public function Group() {
        $Group = new GroupClass($this->SendRequest);
        return $Group;
    }
    
    public function Chatroom() {
        $Chatroom = new ChatroomClass($this->SendRequest);
        return $Chatroom;
    }
    
    public function Push() {
        $Push = new PushClass($this->SendRequest);
        return $Push;
    }
    
    public function SMS() {
        $SMS = new SMSClass($this->SendRequest);
        return $SMS;
    }
    
}