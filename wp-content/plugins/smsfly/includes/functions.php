<?php
if ( get_option( 'SMSFLY_site_new_post_check' ) ) {
	function smsfly_published_post ( $new_status, $old_status, $post ) {
		if ( ($new_status === 'publish') && ($old_status !== 'publish') && ($post->post_type == 'post') ) {
			$authname = get_user_by('id', $post->post_author);
			$search = ['{USER}', '{POSTID}', '{POSTTITLE}', '{DATE}', '{TIME}', '{SITE}'];
			$replace = [$authname->user_login, $post->ID, $post->post_title, date("d.m.Y"), date("H:i"), $authname->user_url];
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_new_post'));
			$msg = (get_option('SMSFLY_site_to_lat') == 1) ? SMSflyC::translit($msg) : $msg;

			SMSflyC::sendToFly(get_option('SMSFLY_SMS_SOURCE'), get_option('SMSFLY_site_phone'), $msg);
		}
	}
	add_action( 'transition_post_status', 'smsfly_published_post', 10, 3 );
}

if ( get_option( 'SMSFLY_site_update_post_check' ) ) {
	function smsfly_post_update( $post_ID, $post_after, $post_before ) {
		if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) ||
		     $post_before->post_status == 'auto-draft' || $post_before->post_type != 'post' ) {
			return;
		} else {
			$postinfo = get_post($post_ID);
			$authname = get_user_by('id', $postinfo->post_author);
			$search = ['{USER}', '{POSTID}', '{POSTTITLE}', '{DATE}', '{TIME}', '{SITE}'];
			$replace = [$authname->user_login, $post_ID, $post_before->post_title, date("d.m.Y"), date("H:i"), $authname->user_url];
			$msg = str_replace($search, $replace, get_option('SMSFLY_site_update_post'));
			$msg = (get_option('SMSFLY_site_to_lat') == 1) ? SMSflyC::translit($msg) : $msg;

			SMSflyC::sendToFly(get_option('SMSFLY_site_source'), get_option('SMSFLY_site_phone'), $msg );
		}
	}
	add_action( 'post_updated', 'smsfly_post_update', 10, 3 );
}

if ( get_option( 'SMSFLY_send_new_user_notifications_check' ) ) {
	function smsfly_send_new_user_notifications( $user_id ) {
		$authname = get_user_by('id', $user_id);

		$search = ['{USER}', '{DATE}', '{TIME}', '{SITE}', '{EMAIL}', '{IP}'];
		$replace = [$authname->user_login, date("d.m.Y"), date("H:i"), $authname->user_url, $authname->user_email, $_SERVER['REMOTE_ADDR']];
		$msg = str_replace($search, $replace, get_option('SMSFLY_send_new_user_notifications'));
		$msg = (get_option('SMSFLY_site_to_lat') == 1) ? SMSflyC::translit($msg) : $msg;

		SMSflyC::sendToFly(get_option('SMSFLY_site_source'), get_option('SMSFLY_site_phone'), $msg );
	}
	add_action( 'register_new_user', 'smsfly_send_new_user_notifications', 10, 1 );
}

if ( get_option( 'SMSFLY_site_user_login_check' ) ) {
	function smsfly_user_login( $user_login, $user ) {
		$search = ['{USER}', '{DATE}', '{TIME}', '{SITE}', '{EMAIL}', '{IP}'];
		$replace = [$user_login, date("d.m.Y"), date("H:i"), $user->user_url, $user->user_email, $_SERVER['REMOTE_ADDR']];
		$msg = str_replace($search, $replace, get_option('SMSFLY_site_user_login'));
		$msg = (get_option('SMSFLY_site_to_lat') == 1) ? SMSflyC::translit($msg) : $msg;

		SMSflyC::sendToFly(get_option('SMSFLY_site_source'), get_option('SMSFLY_site_phone'), $msg );
	}
	add_action('wp_login', 'smsfly_user_login', 10, 2);
}

if ( get_option( 'SMSFLY_site_install_plugin_check' ) || get_option( 'SMSFLY_site_update_plugin_check' ) ||
     get_option( 'SMSFLY_site_install_theme_check' ) || get_option( 'SMSFLY_site_update_theme_check' )  ) {
	function smsfly_upgrader_post_install ($response, $hook_extra, $result) {
		if ( !isset($hook_extra['type']) && !isset($hook_extra['theme']) && !isset($hook_extra['plugin']) ) return;

		if ( isset($hook_extra['type']) ) {
			$option = 'SMSFLY_site_install_'.$hook_extra['type'];
		} else {
			$option = 'SMSFLY_site_update_'.(( isset($hook_extra['theme']) ) ? 'theme' : 'plugin');
		}

		if ( get_option( $option.'_check') != 1) return;

		$cuser = wp_get_current_user();
		$search = ['{USER}', '{PLUGIN}', '{DATE}', '{TIME}', '{THEME}'];
		$replace = [$cuser->user_login, $result['destination_name'], date("d.m.Y"), date("H:i"), $result['destination_name']];
		$msg = str_replace($search, $replace, get_option($option));
		$msg = (get_option('SMSFLY_site_to_lat') == 1) ? SMSflyC::translit($msg) : $msg;

		SMSflyC::sendToFly(get_option('SMSFLY_site_source'), get_option('SMSFLY_site_phone'), $msg);
	}

	add_action( 'upgrader_post_install', 'smsfly_upgrader_post_install', 10, 3 );
}

if ( get_option( 'SMSFLY_WC_CHECK' ) ) {
	function change_status_client($order_id, $old_status, $new_status, $that) {
		$admin = get_option('SMSFLY_wc_admin_wc-'.$new_status.'_check');
		$adminTemplate = get_option('SMSFLY_wc_admin_wc-'.$new_status);
		$client = get_option('SMSFLY_wc_client_wc-'.$new_status.'_check');
		$clientTemplate = get_option('SMSFLY_wc_client_wc-'.$new_status);


		$search = ['{NUM}', '{SUM}', '{EMAIL}', '{PHONE}', '{FIRSTNAME}', '{LASTNAME}', '{CITY}', '{ADDRESS}', '{BLOGNAME}', '{OLD_STATUS}', '{NEW_STATUS}', '{DATE}', '{TIME}'];
		$replace = [
			$order_id,
			html_entity_decode(strip_tags($that->get_formatted_order_total('',false))),
			$that->get_billing_email(),
			$that->get_billing_phone(),
			$that->get_billing_first_name(),
			$that->get_billing_last_name(),
			empty($that->get_shipping_city()) ? $that->get_billing_city() : $that->get_shipping_city(),
			trim(empty($that->get_shipping_address_1()) ? $that->get_billing_address_1()." ".$that->get_billing_address_2() : $that->get_shipping_address_1()." ".$that->get_shipping_address_2()),
			get_option('blogname'),
			wc_get_order_status_name($old_status),
			wc_get_order_status_name($new_status),
			date("d.m.Y"),
			date("H:i")
		];

		$admin_msg = str_replace($search, $replace, $adminTemplate);
		$admin_msg = (get_option('SMSFLY_to_lat_wc') == 1) ? SMSflyC::translit($admin_msg) : $admin_msg;
		$client_msg = str_replace($search, $replace, $clientTemplate);
		$client_msg = (get_option('SMSFLY_to_lat_wc') == 1) ? SMSflyC::translit($client_msg) : $client_msg;

		if ( $admin == 1 ) {
			SMSflyC::sendToFly(get_option('SMSFLY_name_wc_send'), get_option('SMSFLY_wc_phone'), $admin_msg);
		}

		if ( $client == 1 ) {
			SMSflyC::sendToFly(get_option('SMSFLY_name_wc_send'), $that->get_billing_phone(), $client_msg);
		}
	}
	add_action('woocommerce_order_status_changed', 'change_status_client', 10, 4);
}

if ( get_option('SMSFLY_cf7_onsubmit') ) {
	function sendtest($contactform, $result) {
		$errors = ['validation_failed'];
		if ( in_array($result['status'], $errors) ) return;
		$submission = WPCF7_Submission::get_instance();
		$posted_data = $submission->get_posted_data();

		$to = get_option('SMSFLY_cf7_phone');
		$template = get_option('SMSFLY_cf7_onsubmit_msg');

		$fulltext = implode(';', $posted_data);
		$tolat = get_option('SMSFLY_cf7_to_lat') == 1;
		$fulltext = $tolat ? SMSflyC::translit($fulltext) : $fulltext;

		$shortcodes = $replace = [];
		preg_match_all('/\[.+\]/U', $template, $shortcodes);
		foreach ($shortcodes[0] as $shortcode) {
			switch ($shortcode) {
				case '[DATE]': $replace[] = date("d.m.Y"); break;
				case '[TIME]': $replace[] = date("H:i"); break;
				case '[FULL]': $replace[] = $fulltext; break;
				case '[SHORT]':$replace[] = mb_substr($fulltext, 0, ($tolat ? 140 : 65)); break;
				default:
					$code = str_replace(['[',']'], '', $shortcode);
					$replace[] = isset($posted_data[$code]) ? $posted_data[$code] : '';
			}
		}
		$msg = str_replace($shortcodes[0], $replace, $template);

		SMSflyC::sendToFly(get_option('SMSFLY_cf7_namesend'), $to, $msg);
	}

	add_action( 'wpcf7_submit', 'sendtest', 10, 2 );
}