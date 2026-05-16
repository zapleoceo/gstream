<?php
add_action('admin_menu', 'smsfly_admin_menu');
//register_deactivation_hook(__FILE__, 'SMSFLY_woocommerce_deactivation');
	 
function smsfly_admin_menu() {
	add_menu_page(__("SMS-fly settings", 'smsfly'),'SMS-fly','manage_options', 'SMSFly_settings', 'smsfly_setting_show', 'dashicons-email');
	add_submenu_page('SMSFly_settings', __('SMS-fly settings', 'smsfly'), __('Gateway setup', 'smsfly'), 'manage_options', 'SMSFly_settings', 'smsfly_setting_show');
	add_submenu_page('SMSFly_settings',  __('SMS-fly notifications', 'smsfly'),  __('Notifications settings', 'smsfly'), 'manage_options', 'SMSFly_notify', 'smsfly_site_options_page_show');
	add_submenu_page('SMSFly_settings', __('SMS-fly & Woocommerce', 'smsfly'), __('SMS-fly & Woocommerce', 'smsfly'), 'manage_options', 'SMSFly_woo', 'smsfly_checkwc');
    add_submenu_page('SMSFly_settings', __('SMS-fly & Contact Form 7', 'smsfly'), __('SMS-fly & Contact Form 7', 'smsfly'), 'manage_options', 'SMSFly_cf7', 'smsfly_checkcf7');
	add_submenu_page('SMSFly_settings', __('SMS-fly sending sms', 'smsfly'), __('Send sms', 'smsfly'), 'manage_options', 'smsfly_sms', 'smsfly_sms_show');

	add_action( 'admin_init', 'smsfly_settings_action' );
	add_action( 'admin_init', 'smsfly_sms_action' );
	add_action( 'admin_init', 'smsfly_site_options_action' );
	add_action( 'admin_init', 'smsfly_woo_options_action' );
    add_action( 'admin_init', 'smsfly_cf7_options_action' );
}

//function SMSFLY_woocommerce_deactivation() {
//	    delete_option('SMSFLY_login');
//	    delete_option('SMSFLY_pass');
//	    delete_option('SMSFLY_password');
//	    delete_option('SMSFLY_alfaname');
//	    delete_option('SMSFLY_free_admin_phone');
//	    delete_option('SMSFLY_admin_auth');
//	    delete_option('SMSFLY_site_phone');
//	    delete_option('SMSFLY_name_site_send');
//	    delete_option('SMSFLY_site_new_post_check');
//	    delete_option('SMSFLY_site_new_post');
//	    delete_option('SMSFLY_site_user_login_check');
//	    delete_option('SMSFLY_site_user_login');
//	    delete_option('SMSFLY_site_update_post_check');
//	    delete_option('SMSFLY_site_update_post');
//	    delete_option('SMSFLY_site_install_plugin_check');
//	    delete_option('SMSFLY_site_install_plugin');
//	    delete_option('SMSFLY_site_update_plugin_check');
//	    delete_option('SMSFLY_site_update_plugin');
//	    delete_option('SMSFLY_site_install_theme_check');
//	    delete_option('SMSFLY_site_install_theme');
//	    delete_option('SMSFLY_site_update_theme_check');
//	    delete_option('SMSFLY_site_update_theme');
//	    delete_option('SMSFLY_wc_admin_new_order');
//	    delete_option('SMSFLY_wc_admin_new_order_msg');
//	    delete_option('SMSFLY_wc_admin_order_status');
//	    delete_option('SMSFLY_wc_admin_order_status_msg');
//	    delete_option('SMSFLY_wc_client_new_order');
//	    delete_option('SMSFLY_wc_client_new_order_msg');
//	    delete_option('SMSFLY_wc_client_order_status');
//	    delete_option('SMSFLY_wc_client_order_status_msg');
//	    delete_option('SMSFLY_wc_phone');
//	    delete_option('SMSFLY_name_wc_send');
//	    delete_option('SMSFLY_to_lat_wc');
//	}

function smsfly_settings_action() {
	$SMSFLY_OPTIONS = array(
		'SMSFLY_apikey'
	);

	foreach ($SMSFLY_OPTIONS as $option) {
		register_setting('SMSFLY_OPTIONS', $option);
	}

	require_once( 'smsfly-settings.php' );
}

function smsfly_site_options_action() {
	$SMSFLY_SITE_OPTIONS = array(
		'SMSFLY_site_phone',
		'SMSFLY_site_source',
		'SMSFLY_site_to_lat',
		'SMSFLY_site_new_post_check',
		'SMSFLY_site_new_post',
		'SMSFLY_site_update_post_check',
		'SMSFLY_site_update_post',
		'SMSFLY_send_new_user_notifications_check',
		'SMSFLY_send_new_user_notifications',
		'SMSFLY_site_user_login_check',
		'SMSFLY_site_user_login',
		'SMSFLY_site_install_plugin_check',
		'SMSFLY_site_install_plugin',
		'SMSFLY_site_update_plugin_check',
		'SMSFLY_site_update_plugin',
		'SMSFLY_site_install_theme_check',
		'SMSFLY_site_install_theme',
		'SMSFLY_site_update_theme_check',
		'SMSFLY_site_update_theme'
	);

	foreach ($SMSFLY_SITE_OPTIONS as $value) {
	    	register_setting( 'SMSFLY_SITE_OPTIONS', $value );
	}

	require_once( 'smsfly-site-settings.php' );
}

function smsfly_woo_options_action() {
	$wc_settings_wc_options = [
		'SMSFLY_WC_CHECK',
		'SMSFLY_wc_phone',
		'SMSFLY_name_wc_send',
		'SMSFLY_to_lat_wc'
	];

	$props = function_exists('wc_get_order_statuses') ? wc_get_order_statuses() : [];
	foreach ( $props as $key => $value ) {
		$wc_settings_wc_options[] = 'SMSFLY_wc_admin_'.$key.'_check';
		$wc_settings_wc_options[] = 'SMSFLY_wc_admin_'.$key;
		$wc_settings_wc_options[] = 'SMSFLY_wc_client_'.$key.'_check';
		$wc_settings_wc_options[] = 'SMSFLY_wc_client_'.$key;
	}

	foreach ($wc_settings_wc_options as $value) {
       register_setting( 'smsfly_wc_options_page_group', $value );
	}

	require_once( 'smsfly-wc-settings.php' );
}

function smsfly_cf7_options_action() {
    $wc_settings_wc_options = array(
        'SMSFLY_cf7_onsubmit',
        'SMSFLY_cf7_onsubmit_msg',
        'SMSFLY_cf7_phone',
        'SMSFLY_cf7_namesend',
	    'SMSFLY_cf7_to_lat'
    );

    foreach ($wc_settings_wc_options as $value) {
        register_setting( 'smsfly_cf7_options_page_group', $value );
    }

    require_once( 'smsfly-cf7-settings.php' );
}

function smsfly_sms_action() {
	$SMSFLY_SMS = [
		'SMSFLY_SMS_PHONE',
		'SMSFLY_SMS_TEXT',
		'SMSFLY_SMS_SOURCE',
		'SMSFLY_SMS_SAVE'
	];

	foreach ($SMSFLY_SMS as $option) {
		register_setting('smsfly_sms_options_page_group', $option);
	}
	require_once( 'smsfly-sms-settings.php' );
}