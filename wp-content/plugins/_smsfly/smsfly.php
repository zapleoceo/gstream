<?php
/*
Plugin Name: SMS-Fly для Wordpress
Plugin URI: https://sms-fly.com
Description: SMS уведомления с помощью сервиса SMS-Fly.com
Version: 1.1
Author: SMSFly Dev
URI: https://sms-fly.com
*/

/*  Copyright 2017  SMSFly Dev (email: dev@sms-fly.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__,'smsfly_activate');
register_deactivation_hook(__FILE__,'smsfly_deactivate');

define('SMSFLY_DIR', plugin_dir_path(__FILE__));
define('SMSFLY_INCL', plugin_dir_path(__FILE__) . '/includes/');
define('SMSFLY_URL', plugin_dir_url(__FILE__));

if(is_admin()) {
    include(SMSFLY_DIR.'includes/settings.php');
}
include(SMSFLY_DIR.'includes/smsflyc.php');
include(SMSFLY_DIR.'includes/functions.php');

function smsfly_activate() {

}

function smsfly_deactivate() {
//    delete_option('SMSFLY_login');
//    delete_option('SMSFLY_pass');
}


