<?php

defined('InCosmos') or exit('Access Invalid!');
/**
 * 取广告内容
 *
 * @param unknown_type $ap_id
 * @param unknown_type $type html,js,array
 */
function advshow($ap_id, $type = 'js'){
	if($ap_id < 1)return;
	$time    = time();

    $ap_info = Model('adv')->getApById($ap_id);
//    $ap_info = Model('adv')->getInfo($ap_id,$id);
//    P($ap_info);
    if (!$ap_info)
        return;

	$list = $ap_info['adv_list'];unset($ap_info['adv_list']);
	extract($ap_info);
	if($is_use !== '1'){
	    return ;
	}
	$adv_list = array();
	$adv_info = array();//异步调用的数组格式
	foreach ((array)$list as $k=>$v){
		if($v['adv_start_date'] < $time && $v['adv_end_date'] > $time && $v['is_allow'] == '1'){
		    $adv_list[] = $v;
		}
	}

    if(empty($adv_list)){
        if($ap_class == '1'){//文字广告
			$content .= "<a href=''>";
	        $content .= $default_content;
	        $content .= "</a>";
        }else{
			$width   = $ap_width;
	        $height  = $ap_height;
			$content .= "<a href='' title='".$ap_name."'>";
	        $content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
	        $content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$default_content;
            $content .= "' alt=''/>";
	        $content .= "</a>";
	        $adv_info['adv_title'] = $ap_name;
	        $adv_info['adv_img'] = UPLOAD_SITE_URL."/".ATTACH_ADV."/".$default_content;
	        $adv_info['adv_url'] = '';
        }
    }else {
        $select = 0;
        if($ap_display == '1'){//多广告展示
            $select = array_rand($adv_list);
        }
        $adv_select = $adv_list[$select];
        extract($adv_select);
		//图片广告
		if($ap_class == '0'){
			$width   = $ap_width;
			$height  = $ap_height;
			$pic_content = unserialize($adv_content);
			$pic     = $pic_content['adv_pic'];
			$url     = $pic_content['adv_pic_url'];
			$content .= "<a href='http://".$pic_content['adv_pic_url']."' target='_blank' title='".$adv_title."'>";
			$content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
			$content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$pic;
		    $content .= "' alt='".$adv_title."'/>";
			$content .= "</a>";
	        $adv_info['adv_title'] = $adv_title;
	        $adv_info['adv_img'] = UPLOAD_SITE_URL."/".ATTACH_ADV."/".$pic;
	        $adv_info['adv_url'] = 'http://'.$pic_content['adv_pic_url'];
		}
		//文字广告
		if($ap_class == '1'){
			$word_content = unserialize($adv_content);
			$word    = $word_content['adv_word'];
			$url     = $word_content['adv_word_url'];
			$content .= "<a href='http://".$pic_content['adv_word_url']."' target='_blank'>";
			$content .= $word;
			$content .= "</a>";
		}
        //Flash广告
		if($ap_class == '3'){
			$width   = $ap_width;
			$height  = $ap_height;
			$flash_content = unserialize($adv_content);
			$flash   = $flash_content['flash_swf'];
			$url     = $flash_content['flash_url'];
			$content .= "<a href='http://".$url."' target='_blank'><button style='width:".$width."px; height:".$height."px; border:none; padding:0; background:none;' disabled><object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$width."' height='".$height."'>";
			$content .= "<param name='movie' value='";
			$content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$flash;
			$content .= "' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 --><param name='expressinstall' value='";
			$content .= RESOURCE_SITE_URL."/js/expressInstall.swf'/><!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 --><!--[if !IE]>--><object type='application/x-shockwave-flash' data='";
			$content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$flash;
			$content .= "' width='".$width."' height='".$height."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><param name='expressinstall' value='";
			$content .= RESOURCE_SITE_URL."/js/expressInstall.swf'/><!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 --><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object></button></a>";
		}
    }

	if ($type == 'array' && $ap_class == '0'){
		return $adv_info;
	}

	if ($type == 'js'){
		$content = "document.write(\"".$content."\");";
	}
	return $content;
}

/* 获取 具体的 某个广告 start */
function get_adv($ap_id, $type = 'js',$id ="938"){
    if($ap_id < 1)return;
    $time    = time();

//    $ap_info = Model('adv')->getApById($ap_id);
    $ap_info = Model('adv')->getInfo($ap_id,$id);
//    P($ap_info);
    if (!$ap_info)
        return;

    $list = $ap_info['adv_list'];unset($ap_info['adv_list']);
    extract($ap_info);
    if($is_use !== '1'){
        return ;
    }
    $adv_list = array();
    $adv_info = array();//异步调用的数组格式
    foreach ((array)$list as $k=>$v){
        if($v['adv_start_date'] < $time && $v['adv_end_date'] > $time && $v['is_allow'] == '1'){
            $adv_list[] = $v;
        }
    }

    if(empty($adv_list)){
        if($ap_class == '1'){//文字广告
            $content .= "<a href=''>";
            $content .= $default_content;
            $content .= "</a>";
        }else{
            $width   = $ap_width;
            $height  = $ap_height;
            $content .= "<a href='' title='".$ap_name."'>";
            $content .= "<img style='width:100%;height:100%' border='0' src='";
            $content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$default_content;
            $content .= "' alt=''/>";
            $content .= "</a>";
            $adv_info['adv_title'] = $ap_name;
            $adv_info['adv_img'] = UPLOAD_SITE_URL."/".ATTACH_ADV."/".$default_content;
            $adv_info['adv_url'] = '';
        }
    }else {
        $select = 0;
        if($ap_display == '1'){//多广告展示
            $select = array_rand($adv_list);
        }
        $adv_select = $adv_list[$select];
        extract($adv_select);
        //图片广告
        if($ap_class == '0'){
            $width   = $ap_width;
            $height  = $ap_height;
            $pic_content = unserialize($adv_content);
            $pic     = $pic_content['adv_pic'];
            $url     = $pic_content['adv_pic_url'];
            $content .= "<a href='http://".$pic_content['adv_pic_url']."' target='_blank' title='".$adv_title."'>";
            $content .= "<img width='100%' border='0' src='";
            $content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$pic;
            $content .= "' alt='".$adv_title."'/>";
            $content .= "</a>";
            $adv_info['adv_title'] = $adv_title;
            $adv_info['adv_img'] = UPLOAD_SITE_URL."/".ATTACH_ADV."/".$pic;
            $adv_info['adv_url'] = 'http://'.$pic_content['adv_pic_url'];
        }
        //文字广告
        if($ap_class == '1'){
            $word_content = unserialize($adv_content);
            $word    = $word_content['adv_word'];
            $url     = $word_content['adv_word_url'];
            $content .= "<a href='http://".$pic_content['adv_word_url']."' target='_blank'>";
            $content .= $word;
            $content .= "</a>";
        }
        //Flash广告
        if($ap_class == '3'){
            $width   = $ap_width;
            $height  = $ap_height;
            $flash_content = unserialize($adv_content);
            $flash   = $flash_content['flash_swf'];
            $url     = $flash_content['flash_url'];
            $content .= "<a href='http://".$url."' target='_blank'><button style='width:".$width."px; height:".$height."px; border:none; padding:0; background:none;' disabled><object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$width."' height='".$height."'>";
            $content .= "<param name='movie' value='";
            $content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$flash;
            $content .= "' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 --><param name='expressinstall' value='";
            $content .= RESOURCE_SITE_URL."/js/expressInstall.swf'/><!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 --><!--[if !IE]>--><object type='application/x-shockwave-flash' data='";
            $content .= UPLOAD_SITE_URL."/".ATTACH_ADV."/".$flash;
            $content .= "' width='".$width."' height='".$height."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><param name='expressinstall' value='";
            $content .= RESOURCE_SITE_URL."/js/expressInstall.swf'/><!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 --><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object></button></a>";
        }
    }

    if ($type == 'array' && $ap_class == '0'){
        return $adv_info;
    }

    if ($type == 'js'){
        $content = "document.write(\"".$content."\");";
    }
    return $content;
}
/* 获取 具体的 某个广告 end */

function adv_json($ap_id)
{
    if ($ap_id < 1) return;
    $time = time();
    /* 增加区域选择 start */
        if(isset($_GET['area_id']) && $_GET['area_id'] != '0'){
            $area_id = $_GET['area_id'];
        }else{
            $area_id = 0;
        }
    /* 增加区域选择 end */
    $ap_info = Model('adv')->getApById($ap_id);
//    $ap_info = Model('adv')->getInfo($ap_id,$id);
    /* 整理输出数据 start */
    $data['ap_name'] = $ap_info['ap_name'];
    $data['ap_id'] = $ap_info['ap_id'];
//    P($ap_info);
//    P($area_id);
    for($i=0;$i<count($ap_info['adv_list']);$i++){
         // UPLOAD_SITE_URL."/".ATTACH_ADV."/".
        if($ap_info['adv_list'][$i]['area_id'] == "$area_id"){
//            echo 'ddd';
            $pic_content = unserialize($ap_info['adv_list'][$i]['adv_content']);
            $pic     = UPLOAD_SITE_URL."/".ATTACH_ADV."/".$pic_content['adv_pic'];
            $url     = $pic_content['adv_pic_url'];
            $data['adv_info'][$i]['pic'] = $pic;
            $data['adv_info'][$i]['url'] = $url;
            $data['adv_info'][$i]['title'] = $ap_info['adv_list'][$i]['adv_title'];
        }else{
//            echo 'bbb';
        }
    }
    if(is_array($data['adv_info']) && !empty($data['adv_info'])){
        return $data;
    }else{
        return array();
    }
    /* 整理输出数据 end */
}

/**
 * Replace the UBB tag
 *
 * @param string $ubb
 * @param int $video_sign
 * @return string
 */
function replaceUBBTag($ubb, $video_sign = 1){
    if($video_sign){
        $flash_sign = preg_match("/\[FLASH\](.*)\[\/FLASH\]/iU", $ubb);
    }
    $ubb = str_replace(array(
        '[B]', '[/B]', '[I]', '[/I]', '[U]', '[/U]', '[/FONT]', '[/FONT-SIZE]', '[/FONT-COLOR]'
    ), array(
        '', '', '', '', '', '', '', '', ''
    ), preg_replace(array(
        "/\[URL=(.*)\](.*)\[\/URL\]/iU",
        "/\[FONT=([A-Za-z ]*)\]/iU",
        "/\[FONT-SIZE=([0-9]*)\]/iU",
        "/\[FONT-COLOR=([A-Za-z0-9]*)\]/iU",
        "/\[SMILIER=([A-Za-z_]*)\/\]/iU",
        "/\[IMG\](.*)\[\/IMG\]/iU",
        "/\[FLASH\](.*)\[\/FLASH\]/iU",
        "<img class='pi' src=\"$1\"/>",
    ), array(
        '['.L('nc_link').']',
        "",
        "",
        "",
        "",
        '['.L('nc_img').']',
        ($video_sign == 1?'':'['.L('nc_video').']'),
        ""
    ), $ubb));

    if($video_sign && !empty($flash_sign)){
        $ubb .= "<span nctype=\"theme_read\"><img src=\"".CIRCLE_SITE_URL.'/templates/'.TPL_CIRCLE_NAME."/images/default_play.gif\"></span>";
    }
    return $ubb;
}