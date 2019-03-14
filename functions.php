<?php
/**
 * This is a starter theme by Say Hello
 * This file links the class file for the Theme and through it, any additional classes.
 *
 * Name:        Hello Theme
 * Key:         hello-theme
 * Namespace:   HelloTheme
 * Prefix:      sht
 *
 * Check if WordPress 4.6 and PHP 5.3 or newer and ACF is active
 */

if (version_compare(get_bloginfo('version'), '4.6', '<') || version_compare(PHP_VERSION, '5.4', '<') || ! class_exists('acf')) {
	add_action('admin_notices', function () {
		// translators: Admin notice for system requirements
		echo '<div class="error"><p>' . sprintf(__('This Theme requires PHP %1$s (or newer) and WordPress %2$s (or newer) and the Plugin “Advanced Custom Fields” to function properly. Your site is using PHP %3$s and WordPress %4$s. Please upgrade. The Theme has been automatically deactivated.', 'sha'), '5.4', '4.6', PHP_VERSION, $GLOBALS['wp_version']) . '</p></div>';
	});

	add_action('after_switch_theme', function () {
		switch_theme(get_option('theme_switched'));
	});
} else {
	require_once 'vendor/autoload.php';
	require_once 'inc/funcs-basic.php';

	if (!isset($content_width)) {
		$content_width = 660;
	}

	/**
	 * Returns the Theme Instance
	 *
	 * @return Object Theme Object
	 */
	if (!function_exists('sht_theme')) {
		function sht_theme()
		{
			return SayHello\Theme\Theme::getInstance();
		}
	}

	sht_theme();
	sht_theme()->run();
}
