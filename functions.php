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
 * Check if WordPress 5.0 and PHP 7.4 or newer and ACF is active
 */

if (!defined('DISALLOW_FILE_EDIT')) {
	define('DISALLOW_FILE_EDIT', true);
}


if (!function_exists('dump')) {
	function dump($var, $exit = false)
	{
		echo '<pre>' . print_r($var, true) . '</pre>';
		if ($exit) {
			exit;
		}
	}
}

if (version_compare(get_bloginfo('version'), '5.0', '<') || version_compare(PHP_VERSION, '7.4', '<') || !class_exists('acf')) {
	add_action(
		'admin_notices',
		function () {
			// translators: Admin notice for system requirements
			echo '<div class="error"><p>' . sprintf(__('Dieses Theme benötigt PHP %1$s (oder neuer), WordPress %2$s (oder neuer) und das Plugin «Advanced Custom Fields». Ihre Website verfügt über PHP %3$s und WordPress %4$s. Bitte aktualisieren Sie die Abhängigkeiten. Das Theme wurde automatisch deaktiviert.', 'sha'), '7.0', '5.0', PHP_VERSION, $GLOBALS['wp_version']) . '</p></div>';
		}
	);

	add_action(
		'after_switch_theme',
		function () {
			switch_theme(get_option('theme_switched'));
		}
	);
} else {
	/*
	 * This lot auto-loads a class or trait just when you need it. You don't need to
	 * use require, include or anything to get the class/trait files, as long
	 * as they are stored in the correct folder and use the correct namespaces.
	 *
	 * See http://www.php-fig.org/psr/psr-4/ for an explanation of the file structure
	 * and https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md for usage examples.
	 */
	spl_autoload_register(function ($class) {

		// project-specific namespace prefix
		$prefix = 'SayHello\\Theme\\';

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/src/';

		// does the class use the namespace prefix?
		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) !== 0) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr($class, $len);

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

		// if the file exists, require it
		if (file_exists($file)) {
			require $file;
		}
	});

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
