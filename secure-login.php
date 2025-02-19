<?php
/*
Plugin Name: Secure Login
Plugin URI: https://github.com/Luke22076/wp-secure/
Description: A security plugin that protects login attempts, adds 2FA, uses Captcha, and provides IP blocking.
Version: 1.1
Author: Luvus
Author URI: https://github.com/Luke22076/
License: MIT
*/

// Load the configuration file
$config = include( plugin_dir_path( __FILE__ ) . 'config.php' );

// Retrieve configuration settings
$max_failed_logins = isset( $config['max_failed_logins'] ) ? $config['max_failed_logins'] : 5;
$captcha_failed_attempts = isset( $config['captcha_failed_attempts'] ) ? $config['captcha_failed_attempts'] : 3;
$custom_login_url = isset( $config['custom_login_url'] ) ? $config['custom_login_url'] : 'your-website.com/login';
$enable_2fa = isset( $config['enable_2fa'] ) ? $config['enable_2fa'] : true;
$block_ips = isset( $config['block_ips'] ) ? $config['block_ips'] : true;
$notify_on_suspicious_activity = isset( $config['notify_on_suspicious_activity'] ) ? $config['notify_on_suspicious_activity'] : true;

add_action('wp_login_failed', 'sl_failed_login');
add_action('wp_login', 'sl_reset_failed_login');
add_action('login_form', 'sl_display_captcha');
add_action('authenticate', 'sl_two_factor_auth', 30, 3);

function sl_failed_login($username) {
    if (!isset($_SESSION['failed_login_attempts'])) {
        $_SESSION['failed_login_attempts'] = 0;
    }
    $_SESSION['failed_login_attempts']++;

    if ($_SESSION['failed_login_attempts'] >= $max_failed_logins) {
        wp_die('Too many failed login attempts. Please try again later.');
    }

    if ($_SESSION['failed_login_attempts'] == $captcha_failed_attempts) {
        wp_mail('admin@yourwebsite.com', 'Too many failed logins', "Failed login attempts for user: $username");
    }
}

function sl_reset_failed_login($user_login) {
    unset($_SESSION['failed_login_attempts']);
}

function sl_display_captcha() {
    if (isset($_SESSION['failed_login_attempts']) && $_SESSION['failed_login_attempts'] >= $captcha_failed_attempts) {
        echo '<p><label for="captcha">Please prove you are not a robot.</label></p>';
        echo '<input type="text" name="captcha" id="captcha" required />';
    }
}

function sl_two_factor_auth($user, $username, $password) {
    global $enable_2fa;
    if ($enable_2fa && $user && isset($_POST['captcha']) && $_POST['captcha'] == '1234') {
        return $user;
    }

    return new WP_Error('authentication_failed', '2FA verification failed.');
}

function sl_custom_login_url() {
    global $custom_login_url;
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
        wp_redirect($custom_login_url);
        exit();
    }
}
add_action('init', 'sl_custom_login_url');

function sl_block_ip_on_brute_force() {
    if (isset($_SESSION['failed_login_attempts']) && $_SESSION['failed_login_attempts'] >= $max_failed_logins && $block_ips) {
        $blocked_ips = get_option('sl_blocked_ips', []);
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (in_array($ip, $blocked_ips)) {
            wp_die('You have been blocked due to too many failed login attempts.');
        }
        
        if ($_SESSION['failed_login_attempts'] >= $max_failed_logins) {
            $blocked_ips[] = $ip;
            update_option('sl_blocked_ips', $blocked_ips);
        }
    }
}
add_action('init', 'sl_block_ip_on_brute_force');
