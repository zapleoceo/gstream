<?
function smsfly_setting_show() {
    if ( ! current_user_can( 'manage_options' ) ) {
	    wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
    }

	if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
	    add_settings_error('SMSFly_setting_group', 'settings_updated', __('Settings saved.'), 'updated');
	    settings_errors( 'SMSFly_setting_group' );
    }
?>

<div class="wrap">
    <h3><?php get_SMSFLY_balance(); ?></h3>
    <form method="post" action="options.php">
        <?php settings_fields( 'SMSFLY_OPTIONS' );?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="SMSFLY_LOGIN">Логин на sms-fly.com</label></th>
                <td>
                    <input name="SMSFLY_LOGIN" type="text" id="SMSFLY_LOGIN" value="<?php echo get_option('SMSFLY_LOGIN'); ?>" placeholder="380ХХYYYYYYY" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="SMSFLY_PASSWORD">Ваш пароль</label></th>
                <td>
                    <input name="SMSFLY_PASSWORD" type="text" id="SMSFLY_PASSWORD" value="<?php echo get_option('SMSFLY_PASSWORD'); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="SMSFLY_SOURCE">Альфаимя</label></th>
                <td>
                    <input name="SMSFLY_SOURCE" type="text" id="SMSFLY_SOURCE" value="<?php echo get_option('SMSFLY_SOURCE'); ?>" class="regular-text">
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
<?php do_action('smsfly_setting_show');
}

function get_SMSFLY_balance() {
    $login = get_option('SMSFLY_login');
    $password = get_option('SMSFLY_password');
    $SF = new SmsFlyC($login,$password);
    echo $SF->sfBalance();
}