<?php

namespace SayHello\Theme;

use WP_Error;
use WP_Theme_JSON;

/**
 * Theme class which gets loaded in functions.php.
 * Defines the Starting point of the Theme and registers Packages.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Theme
{

	/**
	 * the instance of the object, used for singelton check
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Theme name
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Theme version
	 *
	 * @var string
	 */
	public $version = '';

	/**
	 * Theme prefix
	 *
	 * @var string
	 */
	public $prefix = '';

	/**
	 * Error message
	 *
	 * @var string
	 */
	public $error = '';

	/**
	 * Debug mode
	 *
	 * @var bool
	 */
	public $debug = false;

	private $theme;

	/**
	 * Will be filled with the json decoded contents of assets/settings.json
	 * but ONLY when it is requested through the getSettings function in
	 * this class. THIS IS A PRIVATE VARIABLE - get it using sht_theme()->getSettings()
	 * @var array
	 */
	private $settings = [];

	public function __construct()
	{
		$this->theme = wp_get_theme();
	}

	public function run()
	{
		$this->loadClasses(
			[
				Package\Helpers::class,
				Package\Assets::class,
				Package\Archives::class,
				Package\BodyClass::class,
				Package\CustomPages::class,
				Package\Customizer::class,
				Package\Error::class,
				Package\Gutenberg::class,
				Package\Language::class,
				Package\Lazysizes::class,
				Package\LoginScreen::class,
				Package\Media::class,
				Package\Navigation::class,
				Package\Shyify::class,
				Package\ThemeOptions::class,

				PostType\Page::class,
				PostType\Post::class,

				Block\ArchiveTitleSearch::class,
				Block\ShtMenuToggle::class,
				Block\TemplatePart::class,

				Plugin\ACF::class,
				Plugin\EnableMediaReplace::class, // Delete if the "Enable Media Replace" plugin is not in use
				//Plugin\GravityForms::class, // Comment in if the GF plugin is being used
				//Plugin\Yoast::class, // Comment in if the Yoast plugin is being used
			]
		);

		add_action('after_setup_theme', [$this, 'themeSupports']);
		add_action('after_setup_theme', [$this, 'contentWidth']);

		add_action('comment_form_before', [$this, 'enqueueReplyScript']);

		add_filter('style_loader_tag', [$this, 'removeTypeAttributes']);
		add_filter('script_loader_tag', [$this, 'removeTypeAttributes']);

		add_action('wp_head', [$this, 'headExtras'], 0, 0);
		add_action('wp_footer', [$this, 'noJsScript']);

		$this->cleanHead();
	}

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @return object       The class instance.
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance) && !(self::$instance instanceof Theme)) {
			self::$instance = new Theme;

			self::$instance->name    = self::$instance->theme->name;
			self::$instance->version = self::$instance->theme->version;
			self::$instance->prefix  = 'sht';
			self::$instance->error   = _x('Ein unerwarteter Fehler ist geschehen.', 'Theme instance unexpected error', 'sht');

			// Add define('WP_DEBUG', true); to wp-config.php
			if (defined('WP_DEBUG') && WP_DEBUG) {
				self::$instance->debug = true;
			}
		}

		return self::$instance;
	}

	/**
	 * Loads and initializes the provided classes.
	 *
	 * @param $classes
	 */
	private function loadClasses($classes)
	{
		foreach ($classes as $class) {
			$class_parts = explode('\\', $class);
			$class_short = end($class_parts);
			$class_set   = $class_parts[count($class_parts) - 2];

			if (!isset(sht_theme()->{$class_set}) || !is_object(sht_theme()->{$class_set})) {
				sht_theme()->{$class_set} = new \stdClass();
			}

			if (property_exists(sht_theme()->{$class_set}, $class_short)) {
				wp_die(sprintf(_x('Ein Problem ist geschehen im Theme. Nur eine PHP-Klasse namens «%1$s» darf dem Theme-Objekt «%2$s» zugewiesen werden.', 'Duplicate PHP class assignmment in Theme', 'sht'), $class_short, $class_set), 500);
			}

			sht_theme()->{$class_set}->{$class_short} = new $class();

			if (method_exists(sht_theme()->{$class_set}->{$class_short}, 'run')) {
				sht_theme()->{$class_set}->{$class_short}->run();
			}
		}
	}

	/**
	 * Allow the Theme to use additional core features
	 * https://developer.wordpress.org/reference/functions/add_theme_support/
	 */
	public function themeSupports()
	{

		// Adds RSS feed links to the header
		add_theme_support('automatic-feed-links');

		// Use HTML5 tags in the listed pre-defined elements
		add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);

		// Add post thumbnail support to post types
		add_theme_support('post-thumbnails', ['post']);

		// Adds TITLE tag to header and allows it to be filtered.
		add_theme_support('title-tag');

		// Adding support for responsive embedded content.
		add_theme_support('responsive-embeds');
	}

	public function cleanHead()
	{
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
	}

	/**
	 * Adds a JS script to the head that removes 'no-js' from the html class list
	 */
	public function noJsScript()
	{
		echo "<script>document.querySelector('body').classList.remove('no-js');</script>" . chr(10);
	}

	public function headExtras()
	{
		echo chr(10) . '<!-- Developed for WordPress by Say Hello GmbH - https://sayhello.ch -->' . chr(10) . chr(10);
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';

		// XFN is a HTML profile which describes the meaning of extra semantic data that can be added to the rel attribute of outbound links.
		// http://gmpg.org/xfn/
		echo '<link rel="profile" href="http://gmpg.org/xfn/11">';
	}

	/**
	 * If comments are allowed for the current post/page and if the "reply"
	 * feature is also allowed, add an extra JavaScript from Core to support this.
	 *
	 * @return void
	 */
	public function enqueueReplyScript()
	{
		if (is_singular() && get_option('thread_comments') && comments_open()) {
			wp_enqueue_script('comment-reply');
		}
	}

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 * This is used by e.g. oEmbed when loading Youtube or other embedded iframes.
	 *
	 * The initial value comes from settings.layout.contentSize in theme.json
	 * and can be filtered using 'sht/content_width'.
	 *
	 * @return void
	 */
	public function contentWidth()
	{
		if (file_exists(get_stylesheet_directory() . '/theme.json')) {
			$json = json_decode(file_get_contents(get_stylesheet_directory() . '/theme.json'), true);
			$GLOBALS['content_width'] = (int) apply_filters('sht/content_width', $json['settings']['layout']['contentSize'] ?? 500);
		}
	}

	/**
	 * Load the contents of assets/settings.json into a class
	 * variable (once per request) and return it
	 *
	 * @return array
	 */
	public function getSettings()
	{
		if (!empty($this->settings)) {
			return $this->settings;
		}

		$path = get_template_directory() . '/assets/settings.json';
		if (!is_file($path)) {
			return $this->settings;
		}

		$settings = file_get_contents($path);

		if (is_string($settings) && !empty($settings)) {
			$this->settings = json_decode($settings, true);
		}

		return (array) $this->settings;
	}

	/**
	 * Removes e.g. type="text/javascript" from SCRIPT and STYLE tags
	 * because (according to the W3C Validator), the default values
	 * are not required.
	 *
	 * @return string
	 */

	public function removeTypeAttributes(string $tag = '')
	{
		return (string) preg_replace("/ type=['\"]text\/(javascript|css)['\"]/", '', $tag);
	}

	/**
	 * Gets the contents of theme.json as a WP_Theme_JSON
	 * object and return the settings as an array.
	 *
	 * @return array|WP_Error
	 */
	public function getThemeJson()
	{
		if (!file_exists(get_template_directory() . '/theme.json')) {
			return new WP_Error('404', __('The theme.json file is missing.', 'sha'));
		}

		if (!class_exists('WP_Theme_JSON')) {
			return new WP_Error('404', __('The class “WP_Theme_JSON” is not available', 'sha'));
		}

		$data = file_get_contents(get_template_directory() . '/theme.json');
		$decoded = json_decode($data, true);
		$object = new WP_Theme_JSON($decoded);
		return (array) $object->get_settings();
	}

	/**
	 * Get the specified breakpoint from theme.json.
	 *
	 * @param string $breakpoint
	 * @return int|WP_Error
	 */
	public function getBreakpoint(string $breakpoint)
	{
		$settings = $this->getThemeJson();

		return (int) $settings['custom']['breakpoint'][$breakpoint] ?? new WP_Error('404', sprintf(__('Breakpoint “%s” not found', 'sha'), $breakpoint));
	}
}
