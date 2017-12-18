<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/4/19
 * Time: 10:21
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');

class ClientClass {

    private $appKey;
    private $masterSecret;
    private $retryTimes;
    private $logFile;

    public function __construct($appKey, $masterSecret, $logFile=ConfigClass::DEFAULT_LOG_FILE, $retryTimes=ConfigClass::DEFAULT_MAX_RETRY_TIMES) {
//        echo '111';
//        die;
        if (!is_string($appKey) || !is_string($masterSecret)) {
            echo '33';
            die;
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
        if (!is_null($retryTimes)) {
            $this->retryTimes = $retryTimes;
        } else {
            $this->retryTimes = 1;
        }
        $this->logFile = $logFile;
    }

    public function push() { return new PushPayloadClass($this); }
    public function report() { return new ReportPayloadClass($this); }
    public function device() { return new DevicePayloadClass($this); }
    public function schedule() { return new SchedulePayloadClass($this);}

    public function getAuthStr() { return $this->appKey . ":" . $this->masterSecret; }
    public function getRetryTimes() { return $this->retryTimes; }
    public function getLogFile() { return $this->logFile; }
}
