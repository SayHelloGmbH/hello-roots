<?php

/**
 * This is a WordPress theme by Say Hello
 * This file links the class file for the Theme and through it, any additional classes.
 *
 * Version requirements are set in style.css.
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
