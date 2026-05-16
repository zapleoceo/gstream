<?php
//Contact form 7
if ( get_option('SMSFLY_cf7_onsubmit') == '1') {
    function sendtest($contactform, $result) {
        $to = get_option('SMSFLY_cf7_phone');
        $search = array('{time}', '{name}', '{email}', '{subject}');
        $replace = array(date('Y-m-d H:i:s',time()),wpcf7_flamingo_get_value('name',$contactform),wpcf7_flamingo_get_value('email',$contactform),wpcf7_flamingo_get_value('subject',$contactform));
        $msg = str_replace($search,$replace,get_option('SMSFLY_cf7_onsubmit_msg'));
        $from = get_option('SMSFLY_name_cf7_send');
        $SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from);
        $setting = array(
            'SMSFLY_PHONE' => $to,
            'SMSFLY_TEXT' => $msg
        );
        $SF->sfSendSms($setting);
    }
    add_action( 'wpcf7_submit', 'sendtest', 10, 2 );
}

// оповещение когда опубликован пост.
if ( get_option( 'SMSFLY_site_new_post_check' ) == '1' ) {
	function smsfly_published_post ( $wp_sms_new_status = NULL, $wp_sms_old_status = NULL, $wp_sms_post_ID = NULL ) {
		$sendphone = get_option('SMSFLY_site_phone');
		$from = get_option('SMSFLY_alfaname');
		if ( 'publish' == $wp_sms_new_status && 'publish' != $wp_sms_old_status ) {
			$authname = get_user_by('id', $wp_sms_post_ID->post_author);
			$search = array('{USER}', '{POSTID}', '{POSTTITLE}');
			$replace = array($authname->user_login, $wp_sms_post_ID->ID, $wp_sms_post_ID->post_title);
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_new_post'));

			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
	}
	add_action( 'transition_post_status', 'smsfly_published_post', 10, 3 );
}

// Отправка смс при обновлении записи
if ( get_option( 'SMSFLY_site_update_post_check' ) == '1' ) {
	function smsfly_post_update( $post_ID, $post_after, $post_before ) {
		$sendphone = get_option('SMSFLY_site_phone');
		$from = get_option('SMSFLY_alfaname');
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		} else {
			$postinfo = get_post($post_ID);
			$authname = get_user_by('id', $postinfo->post_author);
			$search = array('{USER}', '{POSTID}', '{POSTTITLE}');
			$replace = array($authname->user_login, $post_ID, $postinfo->post_title);
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_update_post'));
			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
	}
	add_action( 'post_updated', 'smsfly_post_update', 10, 3 );
}

// Отправка смс когда пользователь залогинился
if ( get_option( 'SMSFLY_site_user_login_check' ) == '1' ) {
	if ( ! function_exists( 'get_currentuserinfo' ) ) {
		include( ABSPATH . 'wp-includes/pluggable.php' );
	}
	$sendphone = get_option('SMSFLY_site_phone');
	$from = get_option('SMSFLY_alfaname');
	$SMSFLY_user_logged_in = ! empty ( $current_user->user_login ) ? $current_user->user_login : '';
	if ( '' == $SMSFLY_user_logged_in ) {
		function smsfly_user_login( $SMSFLY_user_logged_in ) {
			global $sendphone, $from;
			$search = array('{USER}', '{TIME}');
			$replace = array($SMSFLY_user_logged_in, date("m.d.Y в H:i:s"));
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_user_login'));
			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
		add_action('wp_login', 'smsfly_user_login', 10, 2);
	}
}

// Отправка смс при установке плагина.
if ( get_option( 'SMSFLY_site_install_plugin_check' ) == '1' ) {
	function smsfly_plugin_install( $a, $b, $c ) {
		if ( $b['type'] == 'plugin' && $b['action'] == 'install' ) {
			$sendphone = get_option('SMSFLY_site_phone');
			$from = get_option('SMSFLY_alfaname');
			$search = array('{PLUGIN}', '{TIME}');
			$replace = array($c['destination_name'], date("m.d.Y в H:i:s"));
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_install_plugin'));
			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
	}
	add_action( 'upgrader_post_install', 'smsfly_plugin_install', 10, 3 );
}

// Отправка смс при обновлении плагина.
if ( get_option( 'SMSFLY_site_update_plugin_check' ) == '1' ) {
	function smsfly_plugin_updated( $a, $b, $c ) {
		if ( $b['type'] == 'plugin' && $b['action'] == 'update' ) {
			$sendphone = get_option('SMSFLY_site_phone');
			$from = get_option('SMSFLY_alfaname');
			$search = array('{PLUGIN}', '{TIME}');
			$replace = array($c['destination_name'], date("m.d.Y в H:i:s"));
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_update_plugin'));
			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
	}
	add_action( 'upgrader_post_install', 'smsfly_plugin_updated', 10, 3 );
}

//оповещение при установке темы
if ( get_option( 'SMSFLY_site_install_theme_check' ) == '1' ) {
	function smsfly_theme_install( $a, $b, $c ) {
		if ( $b['type'] == 'theme' && $b['action'] == 'install' ) {
			$sendphone = get_option('SMSFLY_site_phone');
			$from = get_option('SMSFLY_alfaname');
			$search = array('{THEME}', '{TIME}');
			$replace = array($c['destination_name'], date("m.d.Y в H:i:s"));
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_install_theme'));
			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
	}
	add_action( 'upgrader_post_install', 'smsfly_theme_install', 10, 3 );
}

//оповещение при обновлении темы
if ( get_option( 'SMSFLY_site_update_theme_check' ) == '1' ) {
	function smsfly_theme_update( $a, $b, $c ) {
		if ( $b['type'] == 'theme' && $b['action'] == 'update' ) {
			$sendphone = get_option('SMSFLY_site_phone');
			$from = get_option('SMSFLY_alfaname');
			$search = array('{THEME}', '{TIME}');
			$replace = array($c['destination_name'], date("m.d.Y в H:i:s"));
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_update_theme'));
			$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
			$setting = array(
				'SMSFLY_PHONE' => $sendphone,
				'SMSFLY_TEXT' => $msg
			);
			$SF->sfSendSms($setting);
		}
	}
	add_action( 'upgrader_post_install', 'smsfly_theme_update', 10, 3 );
}

//оповещение для администратора о новом заказе
if ( get_option( 'SMSFLY_wc_admin_new_order' ) == '1' ) {
	function smsfly_new_order($order_id, $old_status = '', $new_status = '') {
		$order = new WC_Order($order_id);
		$search = array('{NUM}', '{SUM}', '{EMAIL}', '{PHONE}', '{FIRSTNAME}', '{LASTNAME}', '{CITY}', '{ADDRESS}', '{BLOGNAME}', '{OLD_STATUS}', '{NEW_STATUS}');
		$replace = array($order_id, html_entity_decode(strip_tags($order->get_formatted_order_total())), $order->billing_email, $order->billing_phone, $order->billing_first_name, $order->billing_last_name,
		$order->shipping_city, $order->shipping_address_1.' '.$order->shipping_address_2, get_option('blogname'), wc_get_order_status_name($old_status), wc_get_order_status_name($new_status));
		$sendphone = get_option('SMSFLY_wc_phone');
		$from = get_option('SMSFLY_name_wc_send');
		$msg = str_replace($search, $replace, get_option('SMSFLY_wc_admin_new_order_msg'));
		$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
		$setting = array(
			'SMSFLY_PHONE' => $sendphone,
			'SMSFLY_TEXT' => $msg
		);
		$SF->sfSendSms($setting);
	}
	add_action( 'woocommerce_checkout_order_processed', 'smsfly_new_order');
}

//оповещение для клиента о новом заказе
if ( get_option( 'SMSFLY_wc_client_new_order' ) == '1' ) {
	function smsfly_new_order_client($order_id, $old_status = '', $new_status = '') {
		$order = new WC_Order($order_id);
		$search = array('{NUM}', '{SUM}', '{EMAIL}', '{PHONE}', '{FIRSTNAME}', '{LASTNAME}', '{CITY}', '{ADDRESS}', '{BLOGNAME}', '{OLD_STATUS}', '{NEW_STATUS}');
		$replace = array($order_id, html_entity_decode(strip_tags($order->get_formatted_order_total())), $order->billing_email, $order->billing_phone, $order->billing_first_name, $order->billing_last_name,
			$order->shipping_city, $order->shipping_address_1.' '.$order->shipping_address_2, get_option('blogname'), wc_get_order_status_name($old_status), wc_get_order_status_name($new_status));
		//$sendphone = get_option('SMSFLY_wc_phone');
		$from = get_option('SMSFLY_name_wc_send');
		$msg = str_replace($search, $replace, get_option('SMSFLY_wc_client_new_order_msg'));
		$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
		$setting = array(
			'SMSFLY_PHONE' => $order->billing_phone,
			'SMSFLY_TEXT' => $msg
		);
		$SF->sfSendSms($setting);
	}
	add_action( 'woocommerce_checkout_order_processed', 'smsfly_new_order_client');
}

//оповещение для адмна о смене статуса заказа
if ( get_option( 'SMSFLY_wc_admin_order_status' ) == '1' ) {
	function change_status_admin($order_id, $old_status, $new_status, $that) {
		$order = new WC_Order($order_id);
		//Статус по умолчанию не обрабатываем
		if ($order->status === 'processing') {
		    return true;
        }
		$search = array('{NUM}', '{SUM}', '{EMAIL}', '{PHONE}', '{FIRSTNAME}', '{LASTNAME}', '{CITY}', '{ADDRESS}', '{BLOGNAME}', '{OLD_STATUS}', '{NEW_STATUS}');
		$replace = array('№'.$order_id, html_entity_decode(strip_tags($order->get_formatted_order_total())), $order->billing_email, $order->billing_phone, $order->billing_first_name, $order->billing_last_name,
				$order->shipping_city, $order->shipping_address_1.' '.$order->shipping_address_2, get_option('blogname'), wc_get_order_status_name($old_status), wc_get_order_status_name($new_status));
		$sendphone = get_option('SMSFLY_wc_phone');
		$from = get_option('SMSFLY_name_wc_send');
		$msg = str_replace($search, $replace, get_option('SMSFLY_wc_admin_order_status_msg'));
		$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
		$setting = array(
			'SMSFLY_PHONE' => $sendphone,
			'SMSFLY_TEXT' => $msg
		);
		$SF->sfSendSms($setting);
	}
	add_action('woocommerce_order_status_changed', 'change_status_admin', 10, 4);
}

//оповещение для клиента о смене статуса заказа
if ( get_option( 'SMSFLY_wc_client_order_status' ) == '1' ) {
	function change_status_client($order_id, $old_status, $new_status, $that) {
		$order = new WC_Order($order_id);
        //Статус по умолчанию не обрабатываем
        if ($order->status === 'processing') {
            return true;
        }
		$search = array('{NUM}', '{SUM}', '{EMAIL}', '{PHONE}', '{FIRSTNAME}', '{LASTNAME}', '{CITY}', '{ADDRESS}', '{BLOGNAME}', '{OLD_STATUS}', '{NEW_STATUS}');
		$replace = array('№'.$order_id, html_entity_decode(strip_tags($order->get_formatted_order_total())), $order->billing_email, $order->billing_phone, $order->billing_first_name, $order->billing_last_name,
				$order->shipping_city, $order->shipping_address_1.' '.$order->shipping_address_2, get_option('blogname'), wc_get_order_status_name($old_status), wc_get_order_status_name($new_status));
		//$sendphone = get_option('SMSFLY_wc_phone');
		$from = get_option('SMSFLY_name_wc_send');
		$msg = str_replace($search, $replace, get_option('SMSFLY_wc_client_order_status_msg'));
		$SF = new SmsFlyC(get_option('SMSFLY_LOGIN'), get_option('SMSFLY_PASSWORD'), $from );
		$setting = array(
			'SMSFLY_PHONE' => $order->billing_phone,
			'SMSFLY_TEXT' => $msg
		);
		$SF->sfSendSms($setting);
	}
	add_action('woocommerce_order_status_changed', 'change_status_client', 10, 4);
}