<?php

if (!defined('ABSPATH')) {
    exit;
}

class Password_Free_Deactivator
{

    public static function password_free_deactivate()
    {
        delete_transient(PASSWORD_FREE_ACTIVATION_CODE);
        if (get_option(PASSWORD_FREE_SHORTCODE_DEACTIVATION_REMOVE)) {
            Password_Free_Db_Query::password_free_remove_short_codes();
        }
        delete_option(PASSWORD_FREE_TOKEN_FOR_ACCESS_TO_API);
        delete_option(PASSWORD_FREE_UPDATE_NOTIFICATION);
        delete_transient(PASSWORD_FREE_GRACE_PERIOD_END);
        delete_option(PASSWORD_FREE_VERSIONS);
        delete_option(PASSWORD_FREE_INNER_KEY);
        delete_option(PASSWORD_FREE_LOGIN_URL);
        delete_option(PASSWORD_FREE_REGISTER_URL);
        delete_option(PASSWORD_FREE_IS_MAIN_URL);
        delete_option(PASSWORD_FREE_IS_ACTIVATED_FOR_POPUP);
        delete_option(PASSWORD_FREE_SYNCHRONIZATION_STATUS);
        delete_option(PASSWORD_FREE_SYNCHRONIZATION_ID);
        delete_option(PASSWORD_FREE_SYNCHRONIZATION_START_POPUP);
        delete_option(PASSWORD_FREE_SYNCHRONIZATION_FAIL_POPUP);
        delete_option(PASSWORD_FREE_SYNCHRONIZATION_FAIL_BLOCK);
        delete_option(PASSWORD_FREE_SYNCHRONIZATION_PROCESS_SHORT_POPUP);
        delete_transient(PASSWORD_FREE_ACTIVATION_ERROR);
    }

    public static function password_free_deactivate_request()
    {
        $args     = array(
            'method' => 'DELETE',
            'headers' => array
            (
                'content-type' => 'application/json',
                'Authorization' => get_option(PASSWORD_FREE_TOKEN)
            )
        );
        password_free_remote_request(PASSWORD_FREE_DEACTIVATION_URL, $args);
    }
}

