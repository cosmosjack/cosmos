<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/8/29
 * Time: 9:07
 * QQ:  997823131 
 */
class qiniuControl extends BaseUser{
    private $accessKey;
    private $secretKey;
    public function __construct(){
        $this->accessKey = 'I1BdA1TXUHlxk7k2STZDtGQwJtpcBITiI5O7onML'; // 钓友
        $this->secretKey = 'p0ZG5y3Um9E9QIHLr2qJmdazekXJy7SIRbIhwhGV'; // 钓友的七牛
        parent::__construct();
    }
    public function uploadOp(){
        echo 'ddd';
    }

    public function listOp(){
        $qiniu = new Qiniu\Qiniu($this->accessKey, $this->secretKey);

//        var_dump($qiniu);

//        die;
        $list = $qiniu->fileList('diaoyou', [
            'delimiter' => '/',
            //'prefix' => 'test/',
            //'limit' => 5,
        ]);
        $files = $list->fetch();
        var_dump($files);
    }
}