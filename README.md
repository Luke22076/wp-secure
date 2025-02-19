# Secure Login Plugin for WordPress

**Plugin Name:** Secure Login  
**Version:** 1.1  
**License:** MIT  
**Author:** Luvus  
**Author URI:** [https://github.com/Luke22076/](https://github.com/Luke22076/)  
**Plugin URI:** [https://github.com/Luke22076/wp-secure/](https://github.com/Luke22076/wp-secure/)

## Description

The **Secure Login** plugin enhances the security of your WordPress site by adding several protective features to your login process:

- **Brute-Force Protection** with limits on failed login attempts
- **Two-Factor Authentication (2FA)** for additional security
- **Captcha** after a specific number of failed login attempts
- **IP Blocking** after repeated failed login attempts
- **Custom Login URL** to hide the default login page (`wp-login.php`)
- **Email Notifications** on suspicious login attempts

This plugin helps protect against brute-force attacks, spam bots, and unauthorized access to your site by significantly improving login security.

## Features

- **Brute-Force Protection:** Blocks users after a certain number of failed login attempts (configurable).
- **Two-Factor Authentication (2FA):** Option to enable 2FA for additional login security.
- **Captcha at Login:** Displays a CAPTCHA after several failed login attempts to stop automated login attempts.
- **IP Blocking:** Blocks IP addresses that have made repeated failed login attempts.
- **Custom Login URL:** Hides the default WordPress login page and redirects it to a custom URL.
- **Email Notifications:** Sends notifications to the admin after suspicious login attempts.

## Installation

1. Upload the entire plugin folder `secure-login` to the `/wp-content/plugins/` directory of your WordPress site.
2. Go to your WordPress Dashboard and navigate to **Plugins > Installed Plugins**.
3. Find **Secure Login** and click **Activate**.

## Configuration

The plugin uses a **config.php** file for easy configuration. After installation, you can edit the `config.php` file to adjust the settings without modifying the main plugin code.

The available settings in `config.php` are:

- **max_failed_logins**: Maximum number of failed login attempts before blocking the user (default is `5`).
- **captcha_failed_attempts**: Number of failed attempts before enabling CAPTCHA (default is `3`).
- **custom_login_url**: Custom login URL to replace the default `wp-login.php` (default is `'your-website.com/login'`).
- **enable_2fa**: Set to `true` to enable two-factor authentication (default is `true`).
- **block_ips**: Set to `true` to enable IP blocking after failed login attempts (default is `true`).
- **notify_on_suspicious_activity**: Set to `true` to receive email notifications on suspicious login attempts (default is `true`).

Here’s an example of the `config.php` file:

```php
<?php
// Configuration options for the Secure Login Plugin

return array(
    'max_failed_logins' => 5,  // Set the max failed login attempts before blocking the user
    'captcha_failed_attempts' => 3,  // Set the number of failed attempts before enabling CAPTCHA
    'custom_login_url' => 'your-website.com/login',  // Define your custom login URL
    'enable_2fa' => true,  // Set to true to enable two-factor authentication
    'block_ips' => true,  // Enable IP blocking after multiple failed login attempts
    'notify_on_suspicious_activity' => true,  // Enable email notifications for suspicious login attempts
);
```

Modify this configuration file to your needs.

## Example: Custom Login URL

To change the default WordPress login URL, simply modify the `custom_login_url` value in the `config.php` file:

```php
'custom_login_url' => 'your-website.com/login'  // Change this to your custom login URL
```

The plugin will automatically redirect requests to the default `wp-login.php` page to your custom login URL.

## Features in Detail

### Brute-Force Protection
The plugin tracks the number of failed login attempts and blocks the user after a certain threshold, which you can configure in the `config.php` file. If the maximum number of failed attempts is reached, users will be blocked.

### CAPTCHA
A CAPTCHA form will appear after a specific number of failed login attempts to prevent automated login attempts. This is configurable through the `config.php` file.

### Two-Factor Authentication (2FA)
The plugin integrates two-factor authentication (2FA) for enhanced security. If enabled, a CAPTCHA check is added to the login process. You can adjust 2FA settings in the `config.php` file.

### IP Blocking
The plugin can block IP addresses that attempt to log in unsuccessfully multiple times. Once the failed login attempts exceed the configured limit, the IP will be blocked.

### Custom Login URL
Instead of using the default WordPress login page (`wp-login.php`), the plugin allows you to set a custom login URL. This helps hide the login page from potential attackers.

### Email Notifications
The plugin will send an email notification to the site administrator if suspicious login activity (too many failed login attempts) occurs.

## Contributing

If you wish to contribute to the plugin by adding new features or improving existing ones, please fork the repository and create a pull request. Be sure to add tests for any new functionality.

## License

This plugin is licensed under the **MIT License**. See the `LICENSE` file for details.

## Support

If you encounter any issues or need help with the plugin, please create an issue on the [GitHub repository](https://github.com/Luke22076/wp-secure/issues).

## Acknowledgements

This plugin is built using WordPress best practices for security and login protection. Special thanks to the WordPress community for their ongoing contributions to web security.

---

### **How to Customize the Plugin**

1. Edit `config.php` to adjust settings such as the maximum number of failed login attempts, custom login URL, CAPTCHA settings, and more.
2. Upload both the `secure-login.php` and `config.php` to your plugin directory (`/wp-content/plugins/secure-login/`).
3. Activate the plugin and configure it via the `config.php` file.
