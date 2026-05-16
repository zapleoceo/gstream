<?php
function smsfly_site_options_page_show() {
    if ( ! current_user_can( 'manage_options' ) )
	    wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
    if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
	    add_settings_error('smsfly_site_options_page_show_group', 'settings_updated', __('Settings saved.'), 'updated');
	    settings_errors( 'smsfly_site_options_page_show_group' );
    }

    $base_templates = [
	    '{USER} - '.__('author of the post page', 'smsfly'),
	    '{DATE} - '.__('date of action performed', 'smsfly'),
	    '{TIME} - '.__('time of action performed', 'smsfly')
    ];
    $post_templates = [
	    '{POSTID} - '.__('Record page ID number', 'smsfly'),
	    '{POSTTITLE} - '.__('post page name', 'smsfly')
    ];
    $user_templates = [
	    '{EMAIL} - '.__("user's email", 'smsfly'),
	    '{IP} - '.__("user's ip", 'smsfly'),
    ];
    $plugin_templates = [
	    '{PLUGIN} - '.__('plugin name', 'smsfly')
    ];
    $themes_templates = [
	    '{THEME} - '.__('theme name', 'smsfly')
    ];

    $props = [
            ['SMSFLY_site_new_post', __( 'Notification about the publication of a new post', 'smsfly' ), array_merge($base_templates, $post_templates)],
            ['SMSFLY_site_update_post', __( 'Post update notification', 'smsfly' ), array_merge($base_templates, $post_templates)],
	        ['SMSFLY_send_new_user_notifications', __( 'Notification about new user registration', 'smsfly' ), array_merge($base_templates, $user_templates)],
            ['SMSFLY_site_user_login', __( 'Notification that the user has logged in to the site', 'smsfly' ), array_merge($base_templates, $user_templates)],
            ['SMSFLY_site_install_plugin', __( 'Notification about installing a new plugin', 'smsfly' ), array_merge($base_templates, $plugin_templates)],
            ['SMSFLY_site_update_plugin', __( 'Plugin update notification', 'smsfly' ), array_merge($base_templates, $plugin_templates)],
            ['SMSFLY_site_install_theme', __( 'Notification about installing a theme on the site', 'smsfly' ), array_merge($base_templates, $themes_templates)],
            ['SMSFLY_site_update_theme', __( 'Topic update notification', 'smsfly' ), array_merge($base_templates, $themes_templates)]
        ];
?>
    <div class="wrap">
        <h2><?php _e('Settings for SMS notifications about events on the site', 'smsfly'); ?></h2>
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
            <?php settings_fields( 'SMSFLY_SITE_OPTIONS' ); ?>
            <table class="form-table">
                <tr><td colspan="3"><h3><?php _e('SMS parameters', 'smsfly'); ?>:</h3></td></tr>
            </table>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="SMSFLY_site_phone"><?php _e("Recipient's phone number", 'smsfly'); ?></label></th>
                    <td>
                        <input name="SMSFLY_site_phone" type="text" id="SMSFLY_site_phone" value="<?php echo get_option('SMSFLY_site_phone'); ?>" placeholder="380XXYYYYYYY" class="regular-text">
                    </td>
                    <td><p class="description"><?php _e("Phone number of the recipient of notification about events on the site, usually the administrator's phone number", 'smsfly'); ?></p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_source"><?php _e('Sender name', 'smsfly'); ?></label></th>
                    <td>
                        <select name="SMSFLY_site_source" id="SMSFLY_site_source" class="regular-text">
                            <?php
                            foreach ( $names as $name ) {
                                $selected = (get_option('SMSFLY_site_source') === $name) ? 'selected':'';
                                echo "<option value='$name' $selected>$name</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><p class="description"></p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_to_lat"><?php _e('Conversion to Latin', 'smsfly'); ?></label></th>
                    <td>
                        <input name="SMSFLY_site_to_lat" type="checkbox" id="SMSFLY_site_to_lat" <?php  checked( '1', get_option('SMSFLY_site_to_lat') ); ?> value="1">
                    </td>
                    <td><p class="description"><?php _e('Enable conversion of Cyrillic characters to Latin', 'smsfly'); ?></p></td>
                </tr>
                <tr><td colspan="3"><h3><?php _e('Alert options', 'smsfly'); ?>:</h3></td></tr>
                <tr>
                    <th><?php _e('Select alert type', 'smsfly'); ?>:</th>
                    <td><select id="SMSFLY_select">
                        <?php
                            $inputs = ''; $li = [];
                            foreach ($props as $prop) {
                                echo "<option value='{$prop[0]}'>{$prop[1]}</option>";
                                $checked = checked( '1', get_option($prop[0].'_check') );
                                $inputs .= "<input type='checkbox' name='$prop[0]_check' $checked value='1' style='display: none'>";
                                $value = get_option($prop[0]);
	                            $inputs .= "<input type='hidden' name='$prop[0]' value='$value'>";

	                            $li[$prop[0]] = '';
                                foreach ($prop[2] as $template_descr) {
	                                $li[$prop[0]] .= "<li>$template_descr</li>";
                                }

                            }
                        ?>
                        </select></td>
                    <td class="description"></td>
                </tr>
                <tr>
                    <th><label><?php _e('Activated', 'smsfly'); ?></label></th>
                    <td><input type="checkbox" id="SMSFLY_input" <?php  checked( '1', get_option('SMSFLY_site_new_post_check') ); ?>></td>
                    <td class="description"><?php _e('Enable for selected alert type', 'smsfly'); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Message template', 'smsfly'); ?></th>
                    <td><textarea rows="4" class="large-text code" id="SMSFLY_textarea"><?php echo get_option('SMSFLY_site_new_post'); ?></textarea></td>
                    <td class="description"><?php _e('Specify the SMS message template using the tags below', 'smsfly'); ?></td>
                </tr>
                <tr><td colspan="3">
                        <p><?php _e('For each type of notification, you can set your own substitutions', 'smsfly'); ?>:
                            <ul id="sms-fly-templates-description">
                                <?php echo $li['SMSFLY_site_new_post'] ?>
                            </ul>
                        </p>
                    </td>
                </tr>
                <script>
                    let li = <?php echo json_encode($li); ?>;
                    let select = document.getElementById('SMSFLY_select'), input = document.getElementById('SMSFLY_input'), textarea = document.getElementById('SMSFLY_textarea')
                    select.addEventListener('change', e => {
                        input.checked = false; textarea.value = ''
                        let prop = e.target.value, prop_input = document.getElementsByName(prop+'_check')[0], prop_textarea = document.getElementsByName(prop)[0]
                        input.checked = prop_input.checked
                        textarea.value = prop_textarea.value

                        let ul = document.getElementById('sms-fly-templates-description')
                        ul.innerHTML = li[prop]
                    })

                    input.addEventListener('change', e => {
                        let prop_input = document.getElementsByName(select.value+'_check')[0]
                        prop_input.checked = input.checked
                    })

                    let textareahandler = e => {
                        let prop_textarea = document.getElementsByName(select.value)[0]
                        prop_textarea.value = textarea.value
                    }
                    textarea.addEventListener('keyup', textareahandler)
                    textarea.addEventListener('change', textareahandler)
                </script>
            </table>
            <?php echo $inputs; submit_button(); ?>
        </form>
    </div>
<?php
}
?>
