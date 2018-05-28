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

if ( version_compare( get_bloginfo( 'version' ), '4.6', '<' ) || version_compare( PHP_VERSION, '5.4', '<' ) || ! class_exists( 'acf' ) ) {

	add_action( 'admin_notices', function () {
		// translators: Admin notice for system requirements
		echo '<div class="error"><p>' . sprintf( __( 'This Theme requires PHP %1$s (or newer) and WordPress %2$s (or newer) and the Plugin “Advanced Custom Fields” to function properly. Your site is using PHP %3$s and WordPress %4$s. Please upgrade. The Theme has been automatically deactivated.', 'sha' ), '5.4', '4.6', PHP_VERSION, $GLOBALS['wp_version'] ) . '</p></div>';
	} );

	add_action( 'after_switch_theme', function () {
		switch_theme( get_option( 'theme_switched' ) );
	} );

} else {

	load_theme_textdomain( 'sht', TEMPLATEPATH . '/languages' ); // Textdomain Frontend
	load_theme_textdomain( 'sha', TEMPLATEPATH . '/languages' ); // Textdomain Admin

	if ( ! isset( $content_width ) ) {
		$content_width = 660;
	}

	require_once 'inc/funcs-basic.php';
	require_once 'inc/funcs.php';

	require_once 'classes/class-themeinstance.php';

	/**
	 * Returns the Theme Instance
	 *
	 * @return Object Theme Object
	 */
	function sht_theme() {
		return HelloTheme\ThemeInstance::get_instance();
	}

	sht_theme();
	sht_theme()->run();

	sht_sayhello_autoload();

	require_once 'classes/class-themeassets.php';
	sht_theme()->Assets = new HelloTheme\ThemeAssets();
	sht_theme()->Assets->run();

	require_once 'classes/class-themecustom.php';
	sht_theme()->Custom = new HelloTheme\ThemeCustom();
	sht_theme()->Custom->run();

	require_once 'classes/class-themeoptions.php';
	sht_theme()->Options = new HelloTheme\ThemeOptions();
	sht_theme()->Options->run();

	require_once 'classes/modules/class-gtm.php';
	sht_theme()->gtm = new sayhello\GTM();
	sht_theme()->gtm->set_property_id( sht_theme()->pfx . '-analytics-tracking-id' );
	sht_theme()->gtm->run();

	/*

	hello_theme();

	hello_theme()->run_default_settings();
	hello_theme()->run_assets();
	hello_theme()->run_theme();

	sht_autoload( [
		'LazySizes',
		'LoginLogo',
		'CustomBodyClass',
		'CustomPtArchive',
		'Hyphenate',
	] );

	require_once 'classes/class-themeoptions.php';
	hello_theme()->Options = new sayhello\Theme\ThemeOptions();
	hello_theme()->Options->run();

	require_once 'classes/class-themecustom.php';
	hello_theme()->Custom = new sayhello\Theme\ThemeCustom();
	hello_theme()->Custom->run();

	require_once 'classes/modules/class-googleanalytics.php';
	hello_theme()->ga = new sayhello\Theme\GoogleAnalytics();
	hello_theme()->ga->set_property_id( 'analytics-tracking-id' );
	hello_theme()->ga->run();
	*/

} // End if().
