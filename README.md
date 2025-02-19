# Secure Login Plugin for WordPress

**Plugin Name:** Secure Login  
**Author:** Luvus 
**Version:** 1.1  
**License:** MIT

## Description

The **Secure Login** plugin enhances the security of your WordPress site by implementing several protective measures:

- **Login protection** with limiting failed login attempts
- **Two-factor authentication (2FA)**
- **IP blocking** after repeated failed login attempts
- **Captcha verification** after multiple failed attempts
- **Notifications** for suspicious login attempts
- **Hiding the default login URL**

This plugin helps prevent brute force attacks, spam bots, and unauthorized access to your site by significantly improving login security.

## Features

- **Brute-force protection:** Lockout after multiple failed login attempts.
- **Two-factor authentication (2FA):** Adds an extra layer of security with 2FA.
- **Captcha at login:** Protect your login page from automated attacks with a CAPTCHA.
- **IP blocking:** Block IPs that repeatedly make incorrect login attempts.
- **Notifications:** Email notifications for suspicious login attempts.
- **Custom login URL:** Hide the default WordPress login URL.

## Installation

1. Upload the entire `secure-login` plugin folder to the `/wp-content/plugins/` directory of your WordPress installation.
2. Go to the WordPress Dashboard and navigate to **Plugins > Installed Plugins**.
3. Look for **Secure Login** and click **Activate**.

## Configuration

After activation, the following features are enabled by default:

- **Brute-force protection:** Lockout after 5 failed login attempts.
- **Captcha:** Enabled after 3 failed login attempts.
- **Custom login URL:** The default login URL (`wp-login.php`) is changed to `your-website.com/login` (this can be customized).

If you want to further configure **2FA** or other features, you may need to integrate additional tools or plugins (e.g., Google Authenticator for 2FA).

## Example of Customizing the Login URL

The plugin changes the default login URL to a custom URL. You can adjust this in the `secure-login.php` file:

```php
function sl_custom_login_url() {
    $custom_login_url = 'your-website.com/login'; // Change this as needed
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
        wp_redirect($custom_login_url);
        exit();
    }
}
add_action('init', 'sl_custom_login_url');
```

Change the value of `$custom_login_url` to the URL you prefer.

## Development and Contributions

If you would like to contribute additional features or improvements, feel free to fork the repository and create a pull request. Please ensure that you add tests for any new functionality.

## License

This plugin is licensed under the **MIT License**. For more details, please refer to the `LICENSE` file in the repository.

---

## Support

If you need assistance or encounter issues with the plugin, you can create an **Issue** in the GitHub repository.

---

## Acknowledgements

This plugin is based on existing security principles and best practices from the WordPress community.

---
