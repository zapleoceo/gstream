<?php
function smsfly_checkcf7() {
	if (in_array('contact-form-7/wp-contact-form-7.php',apply_filters('active_plugins',get_option('active_plugins')))) {
		SMSFLY_send_cf7_options();
	} else {
	?>
	<div class="wrap">
	
		<h2>Настройки СМС оповещений о событиях для Contact Form 7</h2>
	
		<h3>Плагин Contact Form 7 не установлен!!!</h3>
	</div>
	<?php
	}
}

function SMSFLY_send_cf7_options() {
    if ( ! current_user_can( 'manage_options' ) )
	    wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

    if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
	    add_settings_error('smsfly_cf7_options_page_group', 'settings_updated', __('Settings saved.'), 'updated');
	    settings_errors( 'smsfly_cf7_options_page_group' );
    }
    ?>

    <div class="wrap">
        <h2>Настройки СМС оповещений о событиях для Contact Form 7</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'smsfly_cf7_options_page_group' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_phone">Телефон администратора </label></th>
                    <td>
                        <input name="SMSFLY_cf7_phone" type="text" id="SMSFLY_cf7_phone" value="<?php echo get_option('SMSFLY_cf7_phone'); ?>" placeholder="38XXXYYYYYYY" class="regular-text">
                    </td>
                    <td><p class="description"> Номер телефона того кому будет оповещение о отправленной форме CF7, обычно телефон администратора.</p> </td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_name_cf7_send">Альфаимя</label></th>
                    <td>
                        <input name="SMSFLY_name_cf7_send" type="text" id="SMSFLY_name_cf7_send" value="<?php echo get_option('SMSFLY_name_cf7_send'); ?>" class="regular-text">
                    </td>
                    <td><p class="description">Иия оправителя или альфаимя, любое из активных в вашем кабинете на sms-fly.com</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_to_lat_cf7">Конвертация в латиницу</label></th>
                    <td>
                        <input name="SMSFLY_to_lat_cf7" type="checkbox" id="SMSFLY_to_lat_cf7" <?php  checked( '1', get_option('SMSFLY_to_lat_cf7') ); ?> value="1">
                    </td>
                    <td><p class="description">Установите для преобразования киррилических символов в латинские перед отправкой</p></td>
                </tr>
                <tr><td colspan="3"><h3>Уведомление администратору</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_onsubmit">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_cf7_onsubmit" type="checkbox" id="SMSFLY_cf7_onsubmit" <?php  checked( '1', get_option('SMSFLY_cf7_onsubmit') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить сообщение о отправленной форме</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_onsubmit_msg">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_cf7_onsubmit_msg" id="SMSFLY_cf7_onsubmit_msg" class="large-text code" rows="4"><?php echo get_option('SMSFLY_cf7_onsubmit_msg'); ?></textarea>
                    </td>
                    <td><p class="description">Текст уведомления администратору о новой контактной форме,
                                               можно использовать подстановки: <strong>{time}</strong> - дата и время отправки формы,
                                                                               <strong>{name}</strong> - имя отправителя,
                                                                               <strong>{email}</strong> - e-mail отправителя,
                                                                               <strong>{subject}</strong> - тема сообщения.</p></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php do_action('SMSFLY_send_cf7_options');
}
