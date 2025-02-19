<?php
/*
Plugin Name: Secure Login
Plugin URI: https://deine-website.com/secure-login
Description: Ein Sicherheitsplugin, das Login-Versuche schützt, 2FA hinzufügt, Captcha verwendet und IP-Blockierung bietet.
Version: 1.1
Author: Luvus
Author URI: https://deine-website.com
License: MIT
*/

add_action('wp_login_failed', 'sl_failed_login');
add_action('wp_login', 'sl_reset_failed_login');
add_action('login_form', 'sl_display_captcha');
add_action('authenticate', 'sl_two_factor_auth', 30, 3);

function sl_failed_login($username) {
    if (!isset($_SESSION['failed_login_attempts'])) {
        $_SESSION['failed_login_attempts'] = 0;
    }
    $_SESSION['failed_login_attempts']++;

    if ($_SESSION['failed_login_attempts'] >= 5) {
        wp_die('Zu viele fehlgeschlagene Anmeldeversuche. Bitte versuche es später noch einmal.');
    }

    if ($_SESSION['failed_login_attempts'] == 3) {
        wp_mail('admin@deinewebsite.com', 'Zu viele fehlgeschlagene Logins', "Fehlgeschlagene Login-Versuche für Benutzer: $username");
    }
}

function sl_reset_failed_login($user_login) {
    unset($_SESSION['failed_login_attempts']);
}

function sl_display_captcha() {
    if (isset($_SESSION['failed_login_attempts']) && $_SESSION['failed_login_attempts'] >= 3) {
        echo '<p><label for="captcha">Bitte beweisen Sie, dass Sie kein Roboter sind.</label></p>';
        echo '<input type="text" name="captcha" id="captcha" required />';
    }
}

function sl_two_factor_auth($user, $username, $password) {
    if ($user && isset($_POST['captcha']) && $_POST['captcha'] == '1234') {
        return $user;
    }

    return new WP_Error('authentication_failed', 'Die 2FA-Überprüfung ist fehlgeschlagen.');
}

function sl_custom_login_url() {
    $custom_login_url = 'meine-website.de/login';
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
        wp_redirect($custom_login_url);
        exit();
    }
}
add_action('init', 'sl_custom_login_url');

function sl_block_ip_on_brute_force() {
    if (isset($_SESSION['failed_login_attempts']) && $_SESSION['failed_login_attempts'] >= 5) {
        $blocked_ips = get_option('sl_blocked_ips', []);
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (in_array($ip, $blocked_ips)) {
            wp_die('Du wurdest aufgrund zu vieler fehlgeschlagener Login-Versuche gesperrt.');
        }
        
        if ($_SESSION['failed_login_attempts'] >= 5) {
            $blocked_ips[] = $ip;
            update_option('sl_blocked_ips', $blocked_ips);
        }
    }
}
add_action('init', 'sl_block_ip_on_brute_force');
?>
