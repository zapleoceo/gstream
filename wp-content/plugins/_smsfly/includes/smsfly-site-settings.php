<?php

function smsfly_site_options_page_show() {
    if ( ! current_user_can( 'manage_options' ) )
	    wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
    if ( isset( $_GET['settings-updated'] ) && isset( $_GET['page'] ) ) {
	    add_settings_error('smsfly_site_options_page_show_group', 'settings_updated', __('Settings saved.'), 'updated');
	    settings_errors( 'smsfly_site_options_page_show_group' );
    }
    ?>
    <div class="wrap">
        <h2>Настройки СМС оповещений о событиях на сайте</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'SMSFLY_SITE_OPTIONS' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="SMSFLY_site_phone">Телефон администратора</label></th>
                    <td>
                        <input name="SMSFLY_site_phone" type="text" id="SMSFLY_site_phone" value="<?php echo get_option('SMSFLY_site_phone'); ?>" placeholder="380XXYYYYYYY" class="regular-text">
                    </td>
                    <td><p class="description">Номер телефона того кто будет получать оповещения о событиях на сайте, обычно телефон администратора.</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_name_site_send">Альфаимя</label></th>
                    <td>
                        <input name="SMSFLY_name_site_send" type="text" id="SMSFLY_name_site_send" value="<?php echo get_option('SMSFLY_name_site_send'); ?>" class="regular-text">
                    </td>
                    <td><p class="description">Иия оправителя или альфаимя, любое из активных в вашем кабинете на sms-fly.com</p></td>
                </tr>
                <tr><td colspan="3"><h3>Варианты оповещений</h3></td></tr>
                <tr><td colspan="3">
                        <p>Для каждого вида оповещения можно задать свои подстановки:
                            <ul>
                                <li>{USER} - автор страницы/записи</li>
                                <li>{POSTID} - ID номер страницы/записи</li>
                                <li>{POSTTITLE} - название страницы/записи</li>
                                <li>{PLUGIN} - название плагина</li>
                                <li>{TIME} - время выполненного действия</li>
                                <li>{THEME} - название темы</li>
                            </ul>
                        </p>
                    </td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о публикации нового поста</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_new_post_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_new_post_check" type="checkbox" id="SMSFLY_site_new_post_check" <?php  checked( '1', get_option('SMSFLY_site_new_post_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить оповещение о публикации новой записи</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_new_post">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_new_post" id="SMSFLY_site_new_post" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_new_post'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {USER}, {POSTID}, {POSTTITLE}</p></td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о обновлении поста</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_update_post_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_update_post_check" type="checkbox" id="SMSFLY_site_update_post_check" <?php  checked( '1', get_option('SMSFLY_site_update_post_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить оповещение о обновлении поста</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_update_post">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_update_post" id="SMSFLY_site_update_post" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_update_post'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {USER}, {POSTID}, {POSTTITLE}</p></td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о том что пользователь залогинился на сайте</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_user_login_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_user_login_check" type="checkbox" id="SMSFLY_site_user_login_check" <?php  checked( '1', get_option('SMSFLY_site_user_login_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить уведомление что пользователь авторизировался на сайте</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_user_login">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_user_login" id="SMSFLY_site_user_login" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_user_login'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {USER}, {TIME}</p></td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о установке нового плагина</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_install_plugin_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_install_plugin_check" type="checkbox" id="SMSFLY_site_install_plugin_check" <?php  checked( '1', get_option('SMSFLY_site_install_plugin_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить оповещение об установке плагина</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_install_plugin">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_install_plugin" id="SMSFLY_site_install_plugin" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_install_plugin'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {PLUGIN}, {TIME}</p></td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о обновлении плагина</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_update_plugin_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_update_plugin_check" type="checkbox" id="SMSFLY_site_update_plugin_check" <?php  checked( '1', get_option('SMSFLY_site_update_plugin_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить оповещение об обновлении плагина</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_update_plugin">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_update_plugin" id="SMSFLY_site_update_plugin" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_update_plugin'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {PLUGIN}, {TIME}</p></td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о установке темы на сайте</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_install_theme_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_install_theme_check" type="checkbox" id="SMSFLY_site_install_theme_check" <?php  checked( '1', get_option('SMSFLY_site_install_theme_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить оповещение об установке темы</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_install_theme">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_install_theme" id="SMSFLY_site_install_theme" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_install_theme'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {THEME}, {TIME}</p></td>
                </tr>
                <tr><td colspan="3"><h3>Оповещение о обновлении темы</h3></td></tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_update_theme_check">Активировать</label></th>
                    <td>
                        <input name="SMSFLY_site_update_theme_check" type="checkbox" id="SMSFLY_site_update_theme_check" <?php  checked( '1', get_option('SMSFLY_site_update_theme_check') ); ?> value="1">
                    </td>
                    <td><p class="description">Включить оповещение о обновлении темы</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="SMSFLY_site_update_theme">Шаблон сообщения</label></th>
                    <td>
                        <textarea name="SMSFLY_site_update_theme" id="SMSFLY_site_update_theme" class="large-text code" rows="4"><?php echo get_option('SMSFLY_site_update_theme'); ?></textarea>
                    </td>
                    <td><p class="description">Доступные теги: {THEME}, {TIME}</p></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php do_action('smsfly_site_options_page_show');
}
