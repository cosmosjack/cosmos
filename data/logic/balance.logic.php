<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/7/24
 * Time: 10:42
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');
class balanceLogic {
/*
 * 改变卖家的余额
 * 根据不同的order_type 选择不同的订单表
 * 先判断此订单是否已经计算过 （order_id order_type 唯一）
 * 记录在两个表里成功后 再加钱
 */
    public function confirm_order($order_id,$order_type){
        $db_order = new Dpdo();
        $db_pd_log = new Dpdo();
        $db_pd_log->setTable('pd_log');
        switch($order_type){
                case "ES"://二手
//                    echo '二手';
                    $db_order->setTable('flea_order');
                    $data_order = $db_order->where(array('id'=>$order_id))->find();
                    if($data_order){
                        /* 记录日志 start */
                        $insert_log['lg_member_id'] = $data_order['member_id']; //会员ID
                        $insert_log['lg_member_name'] = $data_order['member_name'];//会员名字
                        $insert_log['lg_admin_name'] = '自动转入';  //操作人
                        $insert_log['lg_type'] = 'reward_video';    //转入类型
                        $insert_log['lg_av_amount'] = $data_order['order_amount'];      //转入金额
                        $insert_log['lg_freeze_amount'] = 0;        //冻结金额
                        $insert_log['lg_add_time'] = time();        //记录时间
                        $insert_log['lg_desc'] = '二手订单,交易号:'.$data_order['order_no'];//转入描述

                        $result_log = $db_pd_log->insert($insert_log);
                        if($result_log){
                            $db_pd_log_temp = new Dpdo();
                            $db_pd_log_temp->setTable('pd_log_temp');
                            $insert_log_temp['order_type'] = "ES";
                            $insert_log_temp['order_id'] = $order_id;
                            $insert_log_temp['add_time'] = time();
                            $result_log_tmp = $db_pd_log_temp->insert($insert_log_temp);
                            if($result_log_tmp){

                                /* 给卖家加钱 start */
                                $result = $this->change_money($data_order['member_id'],$data_order['order_amount'],'ES');
                                if($result){
                                    return true;
                                }else{
                                    @$db_pd_log_temp->delete($result_log_tmp);
                                    @$db_pd_log->delete($result_log);
                                    return false;
                                }
                                /* 给卖家加钱 end */

                            }else{
                                //删除上个记录
                                @$db_pd_log->delete($result_log);
                                /* 判断是否已经 收过钱了 start */
                                $data_log_temp = $db_pd_log_temp->where(array('order_id'=>$insert_log_temp['order_id'],'order_type'=>$insert_log_temp['order_type']))->find();
                                if($data_log_temp){
                                    return true;
                                }else{
                                    return false;
                                }
                                /* 判断是否已经 收过钱了 end */
                            }
                        }else{
                            return false;
                        }

                        /* 记录日志 end */

                    }else{
                        return false;
                    }
                    break;
                case "HD"://活动
                    echo '活动';
                    $db_active_oreder = new Dpdo();
                    $db_active_oreder->setTable('dragon_huodong_order');
                    $data_active_order = $db_active_oreder->where(array('orid'=>$order_id))->find();
                    if($data_active_order){
                        echo '有此订单';
                        /* 记录日志 start */
                        $insert_log['lg_member_id'] = $data_active_order['huodongmemberid']; //会员ID
                        $insert_log['lg_member_name'] = $data_active_order['huodongmember_name']?$data_active_order['huodongmember_name']:'保密';//会员名字
                        $insert_log['lg_admin_name'] = '自动转入';  //操作人
                        $insert_log['lg_type'] = 'active_order';    //转入类型
                        $insert_log['lg_av_amount'] = $data_active_order['orjine'];      //转入金额
                        $insert_log['lg_freeze_amount'] = 0;        //冻结金额
                        $insert_log['lg_add_time'] = time();        //记录时间
                        $insert_log['lg_desc'] = '二手订单,交易号:'.$data_active_order['orid'];//转入描述

                        $result_log = $db_pd_log->insert($insert_log);
                        if($result_log){
                            $db_pd_log_temp = new Dpdo();
                            $db_pd_log_temp->setTable('pd_log_temp');
                            $insert_log_temp['order_type'] = "HD";
                            $insert_log_temp['order_id'] = $order_id;
                            $insert_log_temp['add_time'] = time();
                            $result_log_tmp = $db_pd_log_temp->insert($insert_log_temp);
                            if($result_log_tmp){

                                /* 给卖家加钱 start */
                                $result = $this->change_money($data_active_order['huodongmemberid'],$data_active_order['orjine'],'HD');
                                if($result){
                                    return true;
                                }else{
                                    @$db_pd_log_temp->delete($result_log_tmp);
                                    @$db_pd_log->delete($result_log);
                                    return false;
                                }
                                /* 给卖家加钱 end */
                            }else{
                                //删除上个记录
                                @$db_pd_log->delete($result_log);
                                /* 判断是否已经 收过钱了 start */
                                $data_log_temp = $db_pd_log_temp->where(array('order_id'=>$insert_log_temp['order_id'],'order_type'=>$insert_log_temp['order_type']))->find();
                                if($data_log_temp){
                                    return true;
                                }else{
                                    return false;
                                }
                                /* 判断是否已经 收过钱了 end */
                            }
                        }else{
                            return false;
                        }

                        /* 记录日志 end */
                    }else{
                        echo '没有这个订单';
                    }
                    break;
                case "DS"://打赏
                    echo '打赏';
                    break;
                case "FK": //付款
                    echo '付款';
                    break;
                case "ZL"://租赁
                    echo '租赁';
                    break;

            }
    }
    /*
     * 会员加钱或减钱
     */
    private function change_money($member_id,$money,$type){
        /*
         * 根据不同的订单类型 计算不同的提成
         */
        $set = Model('setting');
        if($type == "ES" || $type == "ZL" || $type == "HD"){
            $scale = $set->getRowSetting('other_commission_set_web');
            $money = $money*(1-$scale['value']);
        }
        $db_member = new Dpdo();
        $db_member->setTable('member');
        $result = $db_member->where(array('member_id'=>$member_id))->update("available_predeposit = available_predeposit+{$money}");
        return $result;
    }

}