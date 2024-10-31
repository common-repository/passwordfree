<?php

if (!defined('ABSPATH')) {
    exit;
}

class Password_Free_Header
{

    public static function password_free_get_header()
    {
        wp_enqueue_style("password_free_header", PASSWORD_FREE_URL . 'admin/css/password-free-header.css');
        ?>
        <div class="password-free-header-wrapper">
            <img src="<?php echo esc_url(PASSWORD_FREE_URL . 'admin/images/password-free-header-img.svg') ?>"
                 alt="My Happy SVG"/>
        </div>
        <?php
    }
}


