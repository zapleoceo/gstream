<?php
add_action('admin_menu', 'smsfly_admin_menu');
register_deactivation_hook(__FILE__, 'SMSFLY_woocommerce_deactivation');
	 
function smsfly_admin_menu() {
	add_menu_page('Настройки SMS-Fly','SMS-Fly','manage_options', 'SMSFly_settings', 'smsfly_setting_show', 'dashicons-email');
	add_submenu_page('SMSFly_settings', 'SMS-Fly Настройка', 'Настройка шлюза', 'manage_options', 'SMSFly_settings', 'smsfly_setting_show');
	add_submenu_page('SMSFly_settings', 'SMS-Fly оповещения', 'Настройка оповещений', 'manage_options', 'SMSFly_notify', 'smsfly_site_options_page_show');
	add_submenu_page('SMSFly_settings', 'SMS-Fly и Woocommerce', 'SMS-Fly и Woocommerce', 'manage_options', 'SMSFly_woo', 'smsfly_checkwc');
    add_submenu_page('SMSFly_settings', 'SMS-Fly и Contact Form 7', 'SMS-Fly и Contact Form 7', 'manage_options', 'SMSFly_cf7', 'smsfly_checkcf7');
	add_submenu_page('SMSFly_settings', 'SMS-Fly тестовое сообщение', 'Тестовое сообщение', 'manage_options', 'SMSFly_test', 'smsfly_test_show');

	add_action( 'admin_init', 'smsfly_settings_action' );
	add_action( 'admin_init', 'smsfly_test_action' );
	add_action( 'admin_init', 'smsfly_site_options_action' );
	add_action( 'admin_init', 'smsfly_woo_options_action' );
    add_action( 'admin_init', 'smsfly_cf7_options_action' );
}
	 
function SMSFLY_woocommerce_deactivation() {
	    delete_option('SMSFLY_login');
	    delete_option('SMSFLY_pass');
	    delete_option('SMSFLY_password');
	    delete_option('SMSFLY_alfaname');
	    delete_option('SMSFLY_free_admin_phone');
	    delete_option('SMSFLY_admin_auth');
	    delete_option('SMSFLY_site_phone');
	    delete_option('SMSFLY_name_site_send');
	    delete_option('SMSFLY_site_new_post_check');
	    delete_option('SMSFLY_site_new_post');
	    delete_option('SMSFLY_site_user_login_check');
	    delete_option('SMSFLY_site_user_login');
	    delete_option('SMSFLY_site_update_post_check');
	    delete_option('SMSFLY_site_update_post');
	    delete_option('SMSFLY_site_install_plugin_check');
	    delete_option('SMSFLY_site_install_plugin');
	    delete_option('SMSFLY_site_update_plugin_check');
	    delete_option('SMSFLY_site_update_plugin');
	    delete_option('SMSFLY_site_install_theme_check');
	    delete_option('SMSFLY_site_install_theme');
	    delete_option('SMSFLY_site_update_theme_check');
	    delete_option('SMSFLY_site_update_theme');
	    delete_option('SMSFLY_wc_admin_new_order');
	    delete_option('SMSFLY_wc_admin_new_order_msg');
	    delete_option('SMSFLY_wc_admin_order_status');
	    delete_option('SMSFLY_wc_admin_order_status_msg');
	    delete_option('SMSFLY_wc_client_new_order');
	    delete_option('SMSFLY_wc_client_new_order_msg');
	    delete_option('SMSFLY_wc_client_order_status');
	    delete_option('SMSFLY_wc_client_order_status_msg');
	    delete_option('SMSFLY_wc_phone');
	    delete_option('SMSFLY_name_wc_send');
	    delete_option('SMSFLY_to_lat_wc');
	}

function smsfly_settings_action() {
	$SMSFLY_OPTIONS = array(
		'SMSFLY_LOGIN',
		'SMSFLY_PASSWORD',
		'SMSFLY_SOURCE'
	);

	foreach ($SMSFLY_OPTIONS as $option) {
		register_setting('SMSFLY_OPTIONS', $option);
	}

	require_once( 'smsfly-settings.php' );
}

function smsfly_test_action() {
	$SMSFLY_TEST = array(
		'SMSFLY_PHONE',
		'SMSFLY_TEXT'
	);

	foreach ($SMSFLY_TEST as $option) {
		register_setting('SMSFLY_TEST', $option);
	}
	require_once( 'smsfly-test-settings.php' );
}

function smsfly_site_options_action() {
	$SMSFLY_SITE_OPTIONS = array(
		'SMSFLY_site_phone',
		'SMSFLY_name_site_send',
		'SMSFLY_site_new_post_check',
		'SMSFLY_site_new_post',
		'SMSFLY_site_update_post_check',
		'SMSFLY_site_update_post',
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
	$wc_settings_wc_options = array(
		 'SMSFLY_wc_admin_new_order',
		 'SMSFLY_wc_admin_new_order_msg',
		 'SMSFLY_wc_admin_order_status',
		 'SMSFLY_wc_admin_order_status_msg',
		 'SMSFLY_wc_client_new_order',
		 'SMSFLY_wc_client_new_order_msg',
		 'SMSFLY_wc_client_order_status',
		 'SMSFLY_wc_client_order_status_msg',
		 'SMSFLY_wc_phone',
		 'SMSFLY_name_wc_send'
	);

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
        'SMSFLY_name_cf7_send'
    );

    foreach ($wc_settings_wc_options as $value) {
        register_setting( 'smsfly_cf7_options_page_group', $value );
    }

    require_once( 'smsfly-cf7-settings.php' );
}