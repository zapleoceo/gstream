<?php
function smsfly_checkcf7() {
	if (in_array('contact-form-7/wp-contact-form-7.php',apply_filters('active_plugins',get_option('active_plugins')))) {
		SMSFLY_send_cf7_options();
	} else {
	?>
	<div class="wrap">
	
		<h2><?php _e('SMS event notification settings for Contact Form 7', 'smsfly'); ?></h2>
	
		<h3><?php _e('Contact Form 7 plugin is not installed!!!', 'smsfly'); ?></h3>
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
        <h2><?php _e('SMS event notification settings for Contact Form 7', 'smsfly'); ?></h2>
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
            <?php settings_fields( 'smsfly_cf7_options_page_group' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_phone"><?php _e("Administrator's phone number", 'smsfly'); ?> </label></th>
                    <td>
                        <input name="SMSFLY_cf7_phone" type="text" id="SMSFLY_cf7_phone" value="<?php echo get_option('SMSFLY_cf7_phone'); ?>" placeholder="38XXXYYYYYYY" class="regular-text">
                    </td>
                    <td><p class="description"> <?php _e('The phone number of the person to whom the CF7 form will be notified, usually the administrator’s phone number.', 'smsfly'); ?></p> </td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_namesend"><?php _e('Sender name', 'smsfly'); ?></label></th>
                    <td>
                        <select name="SMSFLY_cf7_namesend" id="SMSFLY_cf7_namesend" class="regular-text">
				            <?php
				            foreach ( $names as $name ) {
					            $selected = (get_option('SMSFLY_cf7_namesend') === $name) ? 'selected':'';
					            echo "<option value='$name' $selected>$name</option>";
				            }
				            ?>
                        </select>
                    </td>
                    <td><p class="description"></p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_to_lat"><?php _e('Conversion to Latin', 'smsfly'); ?></label></th>
                    <td>
                        <input name="SMSFLY_cf7_to_lat" type="checkbox" id="SMSFLY_cf7_to_lat" <?php  checked( '1', get_option('SMSFLY_cf7_to_lat') ); ?> value="1">
                    </td>
                    <td><p class="description"><?php _e('Set to convert Cyrillic characters to Latin before sending', 'smsfly'); ?></p></td>
                </tr>
                <tr><td colspan="3"><h3><?php _e('Notice to Administrator', 'smsfly'); ?></h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_onsubmit"><?php _e('Activate', 'smsfly'); ?></label></th>
                    <td>
                        <input name="SMSFLY_cf7_onsubmit" type="checkbox" id="SMSFLY_cf7_onsubmit" <?php  checked( '1', get_option('SMSFLY_cf7_onsubmit') ); ?> value="1">
                    </td>
                    <td><p class="description"><?php _e('Include form submission message', 'smsfly'); ?></p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_cf7_onsubmit_msg"><?php _e('Message template', 'smsfly'); ?></label></th>
                    <td>
                        <textarea name="SMSFLY_cf7_onsubmit_msg" id="SMSFLY_cf7_onsubmit_msg" class="large-text code" rows="4" placeholder="<?php _e('Enter message template', 'smsfly'); ?>"><?php echo get_option('SMSFLY_cf7_onsubmit_msg'); ?></textarea>
                    </td>
                    <td class="description"><?php _e('Template examples', 'smsfly'); ?>:
                        <br><i>- <?php _e('Form submitted to [TIME]', 'smsfly'); ?></i>
                        <br><i>- <?php _e('User [user-name] submitted a form with the text: [user-text]', 'smsfly'); ?></i>
                        <br><i>- CF7;[TIME];[FULL]</i>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Pattern Substitutions', 'smsfly'); ?></th>
                    <td>
                        <ul>
                            <li><strong>[DATE]</strong> <?php _e('Departure date', 'smsfly'); ?></li>
                            <li><strong>[TIME]</strong> <?php _e('Dispatch time', 'smsfly'); ?></li>
                            <li><strong>[SHORTCODE]</strong> <?php _e('instead of SHORTCODE, you can use any shortcode of an element of any contact form', 'smsfly'); ?></li>
                            <li><strong>[FULL]</strong> <?php _e('all form contents separated by semicolons', 'smsfly'); ?></li>
                            <li><strong>[SHORT]</strong> <?php _e('form content limited to 1 message', 'smsfly'); ?></li>
                        </ul>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php do_action('SMSFLY_send_cf7_options');
}
?>
