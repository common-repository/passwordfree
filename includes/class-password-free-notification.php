<?php

if (!defined('ABSPATH')) {
    exit;
}

class Password_Free_Notification
{

    public function password_free_notify_user_deleted($user_id)
    {
        if ($this->password_free_is_customer($user_id)) {
            $customer_id = get_user_meta($user_id, PASSWORD_FREE_CUSTOMER_ID)[0];
            $args     = array(
                'method' => 'DELETE',
                'headers' => array
                (
                    'content-type' => 'application/json',
                    'Authorization' => get_option(PASSWORD_FREE_TOKEN)
                )
            );
            password_free_remote_request(PASSWORD_FREE_DELETE_CUSTOMER_URL . $customer_id, $args);
        }
    }

    public function password_free_notify_site_email_updated()
    {
        $this->password_free_update_site_info_notification();
    }

    public function password_free_notify_user_email_updated($user_id, $old_user_data)
    {
        $old_user_email = $old_user_data->data->user_email;
        $new_user_email = get_userdata($user_id)->user_email;
        if ($new_user_email === get_option('admin_email')) {
            $this->password_free_update_site_info_notification();
        } else if ($new_user_email !== $old_user_email && $this->password_free_is_customer($user_id)) {
            $costumer_id = get_user_meta($user_id, PASSWORD_FREE_CUSTOMER_ID)[0];
            $this->password_free_update_email_notification($costumer_id);
        }
    }

    public function password_free_notify_pre_delete_site($errors, $old_site) {
        if (is_multisite() && empty($errors->errors)) {
            $old_blog_id = $old_site->blog_id;
            switch_to_blog($old_blog_id);
            $is_main_url = get_option(PASSWORD_FREE_IS_MAIN_URL);
            restore_current_blog();
            if ($is_main_url) {
                $blogs = get_sites();
                $blog_ids_with_active_plugin = password_free_get_ids_with_active_plugin($blogs);
                if (count($blog_ids_with_active_plugin) == 1) {
                        switch_to_blog(get_main_site_id());
                        $site_url = get_site_url();
                        $this->password_free_send_change_url_request($site_url);
                        restore_current_blog();
                } else {
                    for ($i = 0; $i < count($blog_ids_with_active_plugin); $i++) {
                        if ($blog_ids_with_active_plugin[$i] != $old_blog_id) {
                            switch_to_blog($blog_ids_with_active_plugin[$i]);
                            $site_url = get_site_url();
                            $this->password_free_send_change_url_request($site_url);
                            update_option(PASSWORD_FREE_IS_MAIN_URL, true);
                            restore_current_blog();
                            break;
                        }
                    }

                }
            }
        }
    }

    public function password_free_notify_url_updated($old_value, $value)
    {
            $this->password_free_send_change_url_request($value);
    }

    public function password_free_send_change_url_request($value) {
        $data = json_encode(array('url' => $value));
        $args = array(
            'headers' => array
            (
                'content-type' => 'application/json',
                'Authorization' => get_option(PASSWORD_FREE_TOKEN)
            ),
            'body' => $data);
        password_free_remote_post(PASSWORD_FREE_UPDATE_SITE_ADDRESS_URL, $args);
    }

    private function password_free_is_customer($user_id): bool
    {
        return get_user_meta($user_id, PASSWORD_FREE_CUSTOMER_ID)[0] != '';
    }

    private function password_free_update_email_notification($password_free_customer_id)
    {
        $data = json_encode(array('customerId' => $password_free_customer_id));
        $args = array(
            'headers' => array
            (
                'content-type' => 'application/json',
                'Authorization' => get_option(PASSWORD_FREE_TOKEN)
            ),
            'body' => $data);
        password_free_remote_post(PASSWORD_FREE_UPDATE_EMAIL_URL, $args);
    }

    private function password_free_update_site_info_notification()
    {
        $args = array(
            'headers' => array
            (
                'content-type' => 'application/json',
                'Authorization' => get_option(PASSWORD_FREE_TOKEN)
            ));
        password_free_remote_get(PASSWORD_FREE_UPDATE_SITE_INFO_URL, $args);
    }
}
