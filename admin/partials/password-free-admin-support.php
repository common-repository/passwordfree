<?php

if (!defined('ABSPATH')) {
    exit;
}
Password_Free_Header::password_free_get_header();
wp_enqueue_script("password-free-overview-js", PASSWORD_FREE_URL . 'admin/js/password-free-support.js');
wp_enqueue_style("password_free_support", PASSWORD_FREE_URL . 'admin/css/password-free-support.css');
?>
<div id="password-free-page-wrapper">
    <div class="password-free-support-wrapper">
        <?php
        $update_notification = get_option(PASSWORD_FREE_UPDATE_NOTIFICATION);
        if ($update_notification === PASSWORD_FREE_UPDATE_NOTIFICATION_ERROR && get_transient(PASSWORD_FREE_ACTIVATION_ERROR) == '') {
            Password_Free_Notification_Update::password_free_notification_update_error();
        } elseif ($update_notification === PASSWORD_FREE_UPDATE_NOTIFICATION_WARNING) {
            Password_Free_Notification_Update::password_free_notification_update_warning();
        }
        ?>
        <div class="password-free-support-title">Support</div>
        <div class="password-free-support-border">

            <div class="password-free-support-content">
                <ul>
                    <li><a class="password-free-support-link"
                           href="https://docs.passwordfree.us/User_guides/End-user_guide/WordPress_integration/Developer_guide/Install_and_activate_PasswordFree_plugin.htm"
                           target="_blank">Developer
                            Guide</a></li>
                    <li><a class="password-free-support-link"
                           href="https://docs.passwordfree.us/User_guides/End-user_guide/WordPress_integration/User_guide/User_registration.htm"
                           target="_blank">User
                            Guide</a></li>
                    <li><a class="password-free-support-link"
                           href="https://passwordfree.atlassian.net/servicedesk/customer/portal/2/group/4/create/9"
                           target="_blank">Support</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
