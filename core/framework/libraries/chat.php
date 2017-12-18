<?php
/**
 * chat  v3-b12
 *
 *by cosmos-jack  开发修正
 */
defined('InCosmos') or exit('Access Invalid!');

class Chat {
	public static function getChatHtml($layout){
//        P($layout);  //layout/home_layout.php
		$web_html = '';
		if ($layout != 'layout/msg_layout.php' && $layout != 'layout/store_joinin_layout.php'){
			$config_file = BASE_ROOT_PATH.DS.'chat'.DS.'config'.DS."config.ini.php";
			require_once $config_file;
			$avatar = getMemberAvatar($_SESSION['avatar']);
			$store_avatar = getStoreLogo($_SESSION['store_avatar']);
			$nchash = getNchash(); // url+act+op 的MD5 的前八位
//            P($nchash);
			$formhash = Security::getTokenValue(); // 获取令牌
			$css_url = CHAT_TEMPLATES_URL;  // chat/templates/default
			$app_url = APP_SITE_URL;        // http://cosmos-jack.net/chat
			$chat_url = CHAT_SITE_URL;      // http://cosmos-jack.net/chat
			$node_url = NODE_SITE_URL;      //192.168.1.220:3000
			$shop_url = SHOP_SITE_URL;      //http://cosmos-jack.net/shop
			$goods_id = intval($_GET['goods_id']);
			$web_html = <<<EOT
			<link href="{$css_url}/css/chat.css" rel="stylesheet" type="text/css">
			<div style="clear: both;"></div>
			<div id="web_chat_dialog" style="display: none;float:right;">
					</div>
			<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>
			<script type="text/javascript">
			var APP_SITE_URL = '{$app_url}';
                    var CHAT_SITE_URL = '{$chat_url}';
                    var SHOP_SITE_URL = '{$shop_url}';
                    var connect_url = "{$node_url}";

                    var layout = "{$layout}";
                    var act_op = "{$_GET['act']}_{$_GET['op']}";
                    var chat_goods_id = "{$goods_id}";
                    var user = {};

                    user['u_id'] = "{$_SESSION['member_id']}";
                    user['u_name'] = "{$_SESSION['member_name']}";
                    user['s_id'] = "{$_SESSION['store_id']}";
                    user['s_name'] = "{$_SESSION['store_name']}";
                    user['s_avatar'] = "{$store_avatar}";
                    user['avatar'] = "{$avatar}";

                    $("#chat_login").nc_login({
                      nchash:'{$nchash}',
                      formhash:'{$formhash}'
                    });
                    </script>
EOT;
			if (defined('APP_ID') && APP_ID != 'shop'){
                $web_html .= '<link href="' . RESOURCE_SITE_URL . '/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">';
				$web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/perfect-scrollbar.min.js"></script>';
				$web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/jquery.mousewheel.js"></script>';
			}
			$web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/jquery.charCount.js" charset="utf-8"></script>';
			$web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/jquery.smilies.js" charset="utf-8"></script>';
			$web_html .= '<script type="text/javascript" src="'.CHAT_RESOURCE_URL.'/js/user.js" charset="utf-8"></script>';

		}
		if ($layout == 'layout/seller_layout.php'){
		    $web_html .= '<script type="text/javascript" src="'.CHAT_RESOURCE_URL.'/js/store.js" charset="utf-8"></script>';
		    $seller_smt_limits = '';
		    if (!empty($_SESSION['seller_smt_limits']) && is_array($_SESSION['seller_smt_limits'])) {
		        $seller_smt_limits = implode(',', $_SESSION['seller_smt_limits']);
		    }
			$web_html .= <<<EOT
					<script type="text/javascript">
					user['seller_id'] = "{$_SESSION['seller_id']}";
					user['seller_name'] = "{$_SESSION['seller_name']}";
					user['seller_is_admin'] = "{$_SESSION['seller_is_admin']}";
					var smt_limits = "{$seller_smt_limits}";
					</script>
EOT;
		}

		return $web_html;
	}
    // 自己添加的样式
    public static function app_chat_html($layout){
        //        P($layout);  //layout/home_layout.php
        $web_html = '';
        if ($layout != 'layout/msg_layout.php' && $layout != 'layout/store_joinin_layout.php'){
            $config_file = BASE_ROOT_PATH.DS.'chat'.DS.'config'.DS."config.ini.php";
            require_once $config_file;
            $avatar = getMemberAvatar($_SESSION['avatar']);
            $store_avatar = getStoreLogo($_SESSION['store_avatar']);
            $nchash = getNchash(); // url+act+op 的MD5 的前八位
//            P($nchash);
            $formhash = Security::getTokenValue(); // 获取令牌
            $css_url = CHAT_TEMPLATES_URL;  // chat/templates/default
            $app_url = APP_SITE_URL;        // http://cosmos-jack.net/chat
            $chat_url = CHAT_SITE_URL;      // http://cosmos-jack.net/chat
            $node_url = NODE_SITE_URL;      //192.168.1.220:3000
            $shop_url = SHOP_SITE_URL;      //http://cosmos-jack.net/shop
            $goods_id = intval($_GET['goods_id']);
            $web_html = <<<EOT
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<link href="{$css_url}/css/app_chat.css" rel="stylesheet" type="text/css">
			<div style="clear: both;"></div>
			<div id="web_chat_dialog" style="display: block;float:right;">
					</div>
			<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>
			<script type="text/javascript">
			var APP_SITE_URL = '{$app_url}';
                    var CHAT_SITE_URL = '{$chat_url}';
                    var SHOP_SITE_URL = '{$shop_url}';
                    var connect_url = "{$node_url}";

                    var layout = "{$layout}";
                    var act_op = "{$_GET['act']}_{$_GET['op']}";
                    var chat_goods_id = "{$goods_id}";
                    var user = {};

                    user['u_id'] = "{$_SESSION['member_id']}";
                    user['u_name'] = "{$_SESSION['member_name']}";
                    user['s_id'] = "{$_SESSION['store_id']}";
                    user['s_name'] = "{$_SESSION['store_name']}";
                    user['s_avatar'] = "{$store_avatar}";
                    user['avatar'] = "{$avatar}";

                    $("#chat_login").nc_login({
                      nchash:'{$nchash}',
                      formhash:'{$formhash}'
                    });
                    </script>
EOT;
            if (defined('APP_ID') && APP_ID != 'shop'){
                $web_html .= '<link href="' . RESOURCE_SITE_URL . '/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">';
                $web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/perfect-scrollbar.min.js"></script>';
                $web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/jquery.mousewheel.js"></script>';
            }
            $web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/jquery.charCount.js" charset="utf-8"></script>';
            $web_html .= '<script type="text/javascript" src="'.RESOURCE_SITE_URL.'/js/jquery.smilies.js" charset="utf-8"></script>';
            $web_html .= '<script type="text/javascript" src="'.CHAT_RESOURCE_URL.'/js/app_user.js" charset="utf-8"></script>';

        }
        if ($layout == 'layout/seller_layout.php'){
            $web_html .= '<script type="text/javascript" src="'.CHAT_RESOURCE_URL.'/js/store.js" charset="utf-8"></script>';
            $seller_smt_limits = '';
            if (!empty($_SESSION['seller_smt_limits']) && is_array($_SESSION['seller_smt_limits'])) {
                $seller_smt_limits = implode(',', $_SESSION['seller_smt_limits']);
            }
            $web_html .= <<<EOT
					<script type="text/javascript">
					user['seller_id'] = "{$_SESSION['seller_id']}";
					user['seller_name'] = "{$_SESSION['seller_name']}";
					user['seller_is_admin'] = "{$_SESSION['seller_is_admin']}";
					var smt_limits = "{$seller_smt_limits}";
					</script>
EOT;
        }

        return $web_html;
    }
}
?>
