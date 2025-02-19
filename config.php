<?php
// Configuration options for the Secure Login Plugin

return array(
    // Maximum number of failed login attempts before locking the user
    'max_failed_logins' => 5,

    // Number of failed login attempts before enabling CAPTCHA
    'captcha_failed_attempts' => 3,

    // Custom login URL
    'custom_login_url' => 'your-website.com/login',  // Change this as needed

    // Enable Two-Factor Authentication (2FA)
    'enable_2fa' => true,  // true or false

    // IP blocking after repeated failed login attempts
    'block_ips' => true,  // true or false

    // Notifications for suspicious login attempts
    'notify_on_suspicious_activity' => true,  // true or false
);
