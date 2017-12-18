<?php

error_reporting(E_ALL & ~E_NOTICE);
define('BASE_ROOT_PATH',str_replace('\\','/',dirname(__FILE__)));  //根目录
/**
 * 安装判断
 */
if (!is_file(BASE_ROOT_PATH."/install/lock") && is_file(BASE_ROOT_PATH."/install/index.php")){
    if (ProjectName != 'shop'){
        @header("location: ../install/index.php");
    }else{
        @header("location: install/index.php");
    }
    exit;
}

define('BASE_CORE_PATH',BASE_ROOT_PATH.'/core');  // 核心目录
define('BASE_DATA_PATH',BASE_ROOT_PATH.'/data');   // 数据目录
define('DS','/');   // 斜杠
define('InCosmos',true);   // 定义Incosmos  为 真的存在  以确定 以后的文件都有加载此global文件
define('StartTime',microtime(true));  //当前 时间戳
define('TIMESTAMP',time());   //当前时间
define('DIR_SHOP','shop');   // 定义商城文件名 为shop
define('DIR_CMS','cms');   //定义CMS 文件名
define('DIR_CIRCLE','circle');// 定义 圈子 文件名
define('DIR_MICROSHOP','microshop');//定义微商城文件名
define('DIR_ADMIN','admin');//定义后台文件名
define('DIR_API','api'); //定义接口文件名
define('DIR_MOBILE','mobile');//定义手机端文件名
define('DIR_WAP','wap');//定义wap版 文件名
define('DIR_INDIANA','indiana');//定义夺宝 文件名

define('DIR_RESOURCE','data/resource');  //定义公共资源
define('DIR_UPLOAD','data/upload'); //定义上传路径

define('ATTACH_PATH','shop');  //定义商城 特殊文件名
define('ATTACH_COMMON',ATTACH_PATH.'/common');  //定义商城公共 shop/common
define('ATTACH_AVATAR',ATTACH_PATH.'/avatar');  //定义阿凡达 shop/avatar
define('ATTACH_EDITOR',ATTACH_PATH.'/editor');  //定义编辑 shop/editor
define('ATTACH_MEMBERTAG',ATTACH_PATH.'/membertag'); //定义会员tag
define('ATTACH_STORE',ATTACH_PATH.'/store');    //定义商铺
define('ATTACH_GOODS',ATTACH_PATH.'/store/goods');  //定义商铺商品
define('ATTACH_STORE_DECORATION',ATTACH_PATH.'/store/decoration');  //商铺装饰
define('ATTACH_LOGIN',ATTACH_PATH.'/login');    //商城登录
define('ATTACH_WAYBILL',ATTACH_PATH.'/waybill');  //商城运单
define('ATTACH_ARTICLE',ATTACH_PATH.'/article');    //商城文章
define('ATTACH_BRAND',ATTACH_PATH.'/brand');    //商城品牌
define('ATTACH_GOODS_CLASS','shop/goods_class');    //商品类
define('ATTACH_DELIVERY','/delivery');  //商城送货物流
define('ATTACH_ADV',ATTACH_PATH.'/adv');    //商城广告
define('ATTACH_ACTIVITY',ATTACH_PATH.'/activity');  //商城活动
define('ATTACH_WATERMARK',ATTACH_PATH.'/watermark');    //商城水银
define('ATTACH_POINTPROD',ATTACH_PATH.'/pointprod');    //商城定位产品
define('ATTACH_GROUPBUY',ATTACH_PATH.'/groupbuy');      //商城分组
define('ATTACH_LIVE_GROUPBUY',ATTACH_PATH.'/livegroupbuy');//商城动态分组
define('ATTACH_SLIDE',ATTACH_PATH.'/store/slide');  //店铺下跌 排名
define('ATTACH_VOUCHER',ATTACH_PATH.'/voucher');    //商城凭证
define('ATTACH_STORE_JOININ',ATTACH_PATH.'/store_joinin');  //店铺组合 加入
define('ATTACH_REC_POSITION',ATTACH_PATH.'/rec_position');  //商城定位
define('ATTACH_MOBILE','mobile');   //固定值  手机APP 文件名
define('ATTACH_CIRCLE','circle');   //固定值   文章或圈子 文件名
define('ATTACH_CMS','cms');         //固定值   CMS 文件名
define('ATTACH_LIVE','live');       //固定值  生活 文件名
define('ATTACH_MALBUM',ATTACH_PATH.'/member');  //商城会员
define('ATTACH_MICROSHOP','microshop'); //固定值 微商城
define('ATTACH_INDIANA','indiana'); //固定值 夺宝

define('TPL_SHOP_NAME','default');      //视图  商城  默认魔板
define('TPL_CIRCLE_NAME', 'default');   //视图    圈子  默认魔板
define('TPL_MICROSHOP_NAME', 'default');//视图    微商城 默认模板
define('TPL_CMS_NAME', 'default');  //视图    CMS     默认魔板
define('TPL_ADMIN_NAME', 'default');    //视图    后台  默认魔板
define('TPL_ADMIN_NAME', 'default');    //视图    后台  默认魔板
define('TPL_DELIVERY_NAME', 'default'); //视图    物流  默认魔板
define('TPL_MEMBER_NAME', 'default');   //视图    会员  默认魔板
define('TPL_INDIANA_NAME', 'default');   //视图    会员  默认魔板

define('DEFAULT_CONNECT_SMS_TIME', 60);//链接时间限制 60秒

/*
 * 商家入驻状态定义
 */
//新申请
define('STORE_JOIN_STATE_NEW', 10);
//完成付款
define('STORE_JOIN_STATE_PAY', 11);
//初审成功
define('STORE_JOIN_STATE_VERIFY_SUCCESS', 20);
//初审失败
define('STORE_JOIN_STATE_VERIFY_FAIL', 30);
//付款审核失败
define('STORE_JOIN_STATE_PAY_FAIL', 31);
//开店成功
define('STORE_JOIN_STATE_FINAL', 40);

//默认颜色规格id(前台显示图片的规格)
define('DEFAULT_SPEC_COLOR_ID', 1);


/**
 * 商品图片
 */
define('GOODS_IMAGES_WIDTH', '60,240,360,1280');
define('GOODS_IMAGES_HEIGHT', '60,240,360,12800');
define('GOODS_IMAGES_EXT', '_60,_240,_360,_1280');

/**
 *  订单状态
 */
//已取消
define('ORDER_STATE_CANCEL', 0);
//已产生但未支付
define('ORDER_STATE_NEW', 10);
//已支付
define('ORDER_STATE_PAY', 20);
//已发货
define('ORDER_STATE_SEND', 30);
//已收货，交易成功
define('ORDER_STATE_SUCCESS', 40);
//未付款订单，自动取消的天数
define('ORDER_AUTO_CANCEL_DAY', 3);
//已发货订单，自动确认收货的天数
define('ORDER_AUTO_RECEIVE_DAY', 7);
//兑换码支持过期退款，可退款的期限，默认为7天
define('CODE_INVALID_REFUND', 7);
//默认未删除
define('ORDER_DEL_STATE_DEFAULT', 0);
//已删除
define('ORDER_DEL_STATE_DELETE', 1);
//彻底删除
define('ORDER_DEL_STATE_DROP', 2);
//订单结束后可评论时间，15天，60*60*24*15
define('ORDER_EVALUATE_TIME', 1296000);
//抢购订单状态
define('OFFLINE_ORDER_CANCEL_TIME', 3);//单位为天
