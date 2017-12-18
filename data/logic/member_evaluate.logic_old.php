<?php
/**
 * 评价行为
 *
 * @cosmos框架V4 (c) 2005-2016 33hao Inc.
 * @license    http://
 * @link       交流群号：2556239708
 * @since      cosmos框架提供技术支持 cosmos-jack
 */
defined('InCosmos') or exit('Access Invalid!');
class member_evaluateLogic {

    public function evaluateListDity($goods_eval_list) {
        foreach($goods_eval_list as $key=>$value){
			$goods_eval_list[$key]['member_avatar'] = getMemberAvatarForID($value['geval_frommemberid']);
		}
		return $goods_eval_list;
    }
}
