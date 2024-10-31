<?php

if (!defined('ABSPATH')) {
    exit;
}

class Password_Free_Uninstall
{

    public static function password_free_uninstall_request() {
        global $wpdb;
        $wpdb->delete($wpdb->usermeta, ['meta_key' => PASSWORD_FREE_CUSTOMER_ID]);
        $args     = array(
            'method' => 'DELETE',
            'headers' => array
            (
                'content-type' => 'application/json',
                'Authorization' => get_option(PASSWORD_FREE_TOKEN)
            )
        );
        password_free_remote_request(PASSWORD_FREE_UNINSTALL_URL, $args);
    }

    public static function password_free_uninstall()
    {
        delete_option(PASSWORD_FREE_ID);
        delete_option(PASSWORD_FREE_TOKEN_FOR_ACCESS_TO_API);
        delete_option(PASSWORD_FREE_TOKEN);
        delete_option(PASSWORD_FREE_REGISTER_URL);
        delete_option(PASSWORD_FREE_LOGIN_URL);
        delete_option(PASSWORD_FREE_INNER_KEY);
        delete_option(PASSWORD_FREE_IS_DEFAULT_BUTTON_ON);
        delete_option(PASSWORD_FREE_SHORTCODE_DEACTIVATION_REMOVE);

        delete_option(PASSWORD_FREE_CUSTOMIZATION_DEFAULT);
        delete_option(PASSWORD_FREE_CUSTOMIZATION_ALIGNMENT);
        delete_option(PASSWORD_FREE_CUSTOMIZATION_LOGO);
        delete_option(PASSWORD_FREE_CUSTOMIZATION_BUTTONS);
        delete_option(PASSWORD_FREE_CUSTOMIZATION_FONTS);
        delete_option(PASSWORD_FREE_CUSTOMIZATION_CUSTOM);
        delete_option(PASSWORD_FREE_REDIRECT_AFTER_REGISTER_URL);
        delete_option(PASSWORD_FREE_REDIRECT_AFTER_AUTH_URL);
        delete_option(PASSWORD_FREE_IS_MAIN_URL);
        delete_option(PASSWORD_FREE_IS_WAS_ACTIVATED);
        delete_transient(PASSWORD_FREE_ACTIVATION_ERROR);
        Password_Free_Db_Query::password_free_remove_short_codes();
    }

    public static function password_free_delete_dir_in_uploads($dir): bool
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::password_free_delete_dir_in_uploads($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
}