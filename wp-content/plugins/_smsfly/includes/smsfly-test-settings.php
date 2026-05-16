<?php
function smsfly_test_show() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
	}

	if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
		$login = get_option('SMSFLY_LOGIN');
		$password = get_option('SMSFLY_PASSWORD');
		$source = get_option('SMSFLY_SOURCE');
		$SF = new SmsFlyC($login,$password,$source);
		$setting = array(
			'SMSFLY_PHONE' => get_option("SMSFLY_PHONE"),
			'SMSFLY_TEXT' => get_option("SMSFLY_TEXT")
		);

		$response = $SF->sfSendSms($setting);

		add_settings_error( 'SMSFly_setting_group', 'settings_updated', __( $response ), 'updated' );
		settings_errors( 'SMSFly_setting_group' );
	}?>
	<div class="wrap">
		<h3>Отправка сообщения</h3>
		<form method="post" action="options.php">
			<? settings_fields('SMSFLY_TEST'); ?>
			<table class="form-table">
				<tr>
					<th><label for="SMSFLY_PHONE">Номер получателя:</label></th>
					<td><input type="text" id="SMSFLY_PHONE" name="SMSFLY_PHONE" placeholder="38XXXYYYYYYY" value="<? get_option('SMSFLY_PHONE')?>"></td>
                    <td><p class="description"> Введите номер получателя в формате 380ХХХYYYYYYY</p></td>
				</tr>
				<tr>
					<th><label for="SMSFLY_TEXT">Текст сообщения</label></th>
					<td><textarea id="SMSFLY_TEXT" name="SMSFLY_TEXT" class="large-text code"><? get_option('SMSFLY_TEXT');?></textarea></td>
					<td><p class="description"> Текст сообщения не может быть пустым. Одно сообщение до 70 кирилических или 160 латинских символов.</p></td>
				</tr>
			</table>
			<? submit_button('Отправить');?>
		</form>
	</div>
	<?
}