<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/8/12
 * Time: 9:45
 * QQ:  997823131 
 */

spl_autoload_register(function($class){
    /*
     * 先判断 class 是 否被 隔离
     * 如果有隔离 则 查看隔离级别
     * 按不同级别 分别加载 自己的 类
     * 调用的 时候  namespace  的名字 需要 跟 new  后边的 名字 是一样的 就可以调用了
     *
     */
    $class_arr = explode("\\",$class);
    $class_num = count($class_arr);
    $class_path = ROOT_PATH.DS.VENDER;

    if($class_num > 1){
        //算出 需要加载的类的全路径
        for($i=0;$i<$class_num;$i++){
            $class_path .= DS.$class_arr[$i];
        }
        $class_path .= ".php";
    }else{
        $class_path .= $class.".php";
    }
    require_once($class_path);
});
?>


















