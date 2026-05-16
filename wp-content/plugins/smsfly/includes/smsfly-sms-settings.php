<?php
function smsfly_sms_show() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
	}

	if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
		try {
			SMSflyC::sendToFly(get_option('SMSFLY_SMS_SOURCE'), get_option('SMSFLY_SMS_PHONE'), get_option('SMSFLY_SMS_TEXT') );

            if ( SMSflyC::inst()->error ) throw new Exception(SMSflyC::inst()->error);

            $notify = 'Success send';
			$type = 'updated';
		} catch (Exception $e) {
            $notify = $e->getMessage();
            $type = 'error';
        } finally {
			add_settings_error( 'smsfly_sms_options_page_group', 'settings_updated', __( $notify, 'smsfly' ), $type );
			settings_errors( 'smsfly_sms_options_page_group' );
		}
	}?>
	<div class="wrap">
		<h3><?php _e('Manual sending of SMS messages', 'smsfly'); ?></h3>
		<?php
		$names = SMSflyC::inst()->names['sms'];

		if ( SMSflyC::inst()->auth ) {
			$formStyle = '';
		} else {
			add_settings_error('smsfly_site_options_page_show_group', 'settings_updated', __(SMSflyC::inst()->error, 'smsfly'), 'error');
			settings_errors( 'smsfly_site_options_page_show_group' );
			$formStyle = 'display: none';
		}
		?>
		<form method="post" action="options.php" style="<?php echo $formStyle;?>">
			<?php settings_fields( 'smsfly_sms_options_page_group' ); ?>
			<table class="form-table">
                <tr>
                    <th scope="row"><label for="SMSFLY_SMS_SOURCE"><?php _e('Sender name', 'smsfly'); ?></label></th>
                    <td>
                        <select name="SMSFLY_SMS_SOURCE" id="SMSFLY_SMS_SOURCE" class="regular-text">
							<?php
							foreach ( $names as $name ) {
								$selected = (get_option('SMSFLY_SMS_SOURCE') === $name) ? 'selected':'';
								echo "<option value='$name' $selected>$name</option>";
							}
							?>
                        </select>
                    </td>
                    <td><p class="description"></p></td>
                </tr>
				<tr>
					<th><label for="SMSFLY_SMS_PHONE"><?php _e('Recipient number', 'smsfly'); ?>:</label></th>
					<td><input type="text" id="SMSFLY_SMS_PHONE" name="SMSFLY_SMS_PHONE" placeholder="38XXXYYYYYYY" value=""></td>
                    <td><p class="description"> <?php _e("Enter the recipient's number in the format of the recipient's country", 'smsfly'); ?></p></td>
				</tr>
				<tr>
					<th><label for="SMSFLY_SMS_TEXT"><?php _e('Message', 'smsfly'); ?></label></th>
					<td><textarea id="SMSFLY_SMS_TEXT" name="SMSFLY_SMS_TEXT" class="large-text code"><?php echo get_option('SMSFLY_SMS_SAVE')?get_option('SMSFLY_SMS_TEXT'):'';?></textarea></td>
					<td><p class="description"> <?php _e('The message text cannot be empty. One message up to 70 Cyrillic or 160 Latin characters', 'smsfly'); ?>.</p></td>
				</tr>
                <tr>
                    <th><label for="SMSFLY_SMS_SAVE"><?php _e('Save text', 'smsfly'); ?></label></th>
                    <td><input name="SMSFLY_SMS_SAVE" type="checkbox" id="SMSFLY_SMS_SAVE" <?php  checked( '1', get_option('SMSFLY_SMS_SAVE') ); ?> value="1"></td>
                    <td><p class="description"><?php _e('Do not clear the "Message text" field when refreshing the page', 'smsfly'); ?></p></td>
                </tr>
			</table>
			<?php submit_button( __( 'Send a message', 'smsfly' ));?>
		</form>
	</div>
	<?php
}