<?php
function smsfly_checkwc() {
	if (in_array('woocommerce/woocommerce.php',apply_filters('active_plugins',get_option('active_plugins')))) {
		SMSFLY_send_wc_options();
	} else {
	?>
	<div class="wrap">
	
		<h2>Настройки СМС оповещений о событиях для WooCommerce</h2>
	
		<h3>Плагин Woocommerce не установлен!!!</h3>
	</div>
	<?php
	}
}

function SMSFLY_send_wc_options() {
    if ( ! current_user_can( 'manage_options' ) )
	    wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

    if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
	    add_settings_error('smsfly_wc_options_page_group', 'settings_updated', __('Settings saved.'), 'updated');
	    settings_errors( 'smsfly_wc_options_page_group' );
    }
    ?>

    <div class="wrap">
        <h2>Настройки СМС оповещений о событиях для WooCommerce</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'smsfly_wc_options_page_group' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_phone">Телефон администратора </label></th>
                    <td>
                        <input name="SMSFLY_wc_phone" type="text" id="SMSFLY_wc_phone" value="<?php echo get_option('SMSFLY_wc_phone'); ?>" placeholder="380XXXYYYYYYY" class="regular-text">
                    </td>
                    <td><p class="description"> Номер телефона того кто будет получать оповещения о событиях на сайте, обычно телефон администратора.</p> </td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_name_wc_send">Альфаимя</label></th>
                    <td>
                        <input name="SMSFLY_name_wc_send" type="text" id="SMSFLY_name_wc_send" value="<?php echo get_option('SMSFLY_name_wc_send'); ?>" class="regular-text">
                    </td>
                    <td><p class="description">Иия оправителя или альфаимя, любое из активных в вашем кабинете на sms-fly.com</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_to_lat_wc">Конвертация в латиницу</label></th>
                    <td>
                        <input name="SMSFLY_to_lat_wc" type="checkbox" id="SMSFLY_to_lat_wc" <?php  checked( '1', get_option('SMSFLY_to_lat_wc') ); ?> value="1">
                    </td>
                    <td><p class="description">Установите для преобразования киррилических символов в латинские перед отправкой</p></td>
                </tr>
                <tr><td colspan="3"><h3>Варианты оповещений</h3></td></tr>
                <tr>
                    <td colspan="3">
                        <p>Для каждого вида оповещения можно задать свои подстановки:
                            <ul>
                                <li>{NUM} - номер заказа</li>
                                <li>{SUM} - сумма заказа</li>
                                <li>{EMAIL} - E-mail клиента</li>
                                <li>{PHONE} - Телефон клиента</li>
                                <li>{FIRSTNAME} - Имя клиента</li>
                                <li>{LASTNAME} - Фамилия клиента</li>
                                <li>{CITY} - Город клиента</li>
                                <li>{ADDRESS} - Адрес клиента</li>
                                <li>{BLOGNAME} - Название магазина</li>
                                <li>{OLD_STATUS} - Старый статус</li>
                                <li>{NEW_STATUS} - Новый статус</li>
                            </ul>
                        </p>
                    </td>
                </tr>
                <tr><td colspan="3"><h3>Уведомление администратору</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_admin_new_order">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_wc_admin_new_order" type="checkbox" id="SMSFLY_wc_admin_new_order" <?php  checked( '1', get_option('SMSFLY_wc_admin_new_order') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить сообщение о поступлении нового заказа</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_admin_new_order_msg">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_wc_admin_new_order_msg" id="SMSFLY_wc_admin_new_order_msg" class="large-text code" rows="4"><?php echo get_option('SMSFLY_wc_admin_new_order_msg'); ?></textarea>
                    </td>
                    <td><p class="description">Шаблоны подстановок перечислены в начале страницы настроек</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_admin_order_status">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_wc_admin_order_status" type="checkbox" id="SMSFLY_wc_admin_order_status" <?php  checked( '1', get_option('SMSFLY_wc_admin_order_status') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить сообщение о смене статуса заказа</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_admin_order_status_msg">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_wc_admin_order_status_msg" id="SMSFLY_wc_admin_order_status_msg" class="large-text code" rows="4"><?php echo get_option('SMSFLY_wc_admin_order_status_msg'); ?></textarea>
                    </td>
                    <td><p class="description">Шаблоны подстановок перечислены в начале страницы настроек</p></td>
                </tr>
                <tr><td colspan="3"><h3>Уведомление клиенту</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_client_new_order">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_wc_client_new_order" type="checkbox" id="SMSFLY_wc_client_new_order" <?php  checked( '1', get_option('SMSFLY_wc_client_new_order') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить сообщение о новом заказе</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_client_new_order_msg">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_wc_client_new_order_msg" id="SMSFLY_wc_client_new_order_msg" class="large-text code" rows="4"><?php echo get_option('SMSFLY_wc_client_new_order_msg'); ?></textarea>
                    </td>
                    <td><p class="description">Шаблоны подстановок перечислены в начале страницы настроек</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_client_order_status">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_wc_client_order_status" type="checkbox" id="SMSFLY_wc_client_order_status" <?php  checked( '1', get_option('SMSFLY_wc_client_order_status') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить сообщение о смене статуса заказа</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_wc_client_order_status_msg">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_wc_client_order_status_msg" id="SMSFLY_wc_client_order_status_msg" class="large-text code" rows="4"><?php echo get_option('SMSFLY_wc_client_order_status_msg'); ?></textarea>
                    </td>
                    <td><p class="description">Шаблоны подстановок перечислены в начале страницы настроек</p></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php do_action('SMSFLY_send_wc_options');
}
