<?php

namespace SayHello\Theme;

use SayHello\Theme\Package\Helpers;

/**
 * Theme class which gets loaded in functions.php.
 * Defines the Starting point of the Theme and registers Packages.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Theme {

	/**
	 * the instance of the object, used for singelton check
	 * @var object
	 */
	private static $instance;

	/**
	 * Theme name
	 * @var string
	 */
	public $name = '';

	/**
	 * Theme version
	 * @var string
	 */
	public $version = '';

	/**
	 * Theme prefix
	 * @var string
	 */
	public $prefix = '';

	/**
	 * Error message
	 * @var string
	 */
	public $error = '';

	/**
	 * Debug mode
	 * @var bool
	 */
	public $debug = false;

	private $theme;

	public function __construct() {
		$this->theme = wp_get_theme();
	}

	public function run() {
		$this->loadClasses([
			\SayHello\Theme\Package\Helpers::class,
			\SayHello\Theme\Package\Adminbar::class,
			\SayHello\Theme\Package\Assets::class,
			\SayHello\Theme\Package\Ajax::class,
			\SayHello\Theme\Package\BodyClass::class,
			\SayHello\Theme\Package\CustomPages::class,
			\SayHello\Theme\Package\Error::class,
			\SayHello\Theme\Package\Language::class,
			\SayHello\Theme\Package\Lazysizes::class,
			\SayHello\Theme\Package\LoginScreen::class,
			\SayHello\Theme\Package\Media::class,
			\SayHello\Theme\Package\NavWalker::class,
			\SayHello\Theme\Package\Sidebars::class,
			\SayHello\Theme\Package\SVG::class,
			\SayHello\Theme\Package\ThemeOptions::class,
		]);

		add_action('after_setup_theme', [$this, 'addNavigations']);
		add_action('after_setup_theme', [$this, 'addThemeSupports']);

		add_action('wp_head', [$this, 'noJsScript']);
		add_action('wp_head', [$this, 'browserOutdatedScript']);
		add_action('wp_head', [$this, 'humansTxt']);

		add_action('wp_footer', [$this, 'browserRequirements'], 100);

		$this->cleanHead();
		$this->setTimezone();
	}

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 * @return object       The class instance.
	 */
	public static function get_instance() {

		if (!isset(self::$instance) && !(self::$instance instanceof Theme)) {

			self::$instance = new Theme;

			self::$instance->name = self::$instance->theme->name;
			self::$instance->version = self::$instance->theme->version;
			self::$instance->prefix = 'sht';
			self::$instance->error = __('An unexpected error occured.', 'sht');
			self::$instance->debug = true;

			if (!isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], '.hello') === false && !in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
				self::$instance->debug = false;
			}
		}

		return self::$instance;
	}

	/**
	 * Loads and initializes the provided classes.
	 *
	 * @param $classes
	 */
	private function loadClasses($classes) {
		foreach ($classes as $class) {
			sht_theme()->$class = new $class();
			if (method_exists(sht_theme()->$class, 'run')) {
				sht_theme()->$class->run();
			}
		}
	}

	/**
	 * Allow the Theme to use additional core features
	 */
	public function addThemeSupports() {
		add_theme_support('automatic-feed-links');
		add_theme_support('custom-logo', [
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		]);
		add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
		add_theme_support('menu');
		add_theme_support('post-thumbnails', ['post']);
		add_theme_support('title-tag');
	}

	/**
	 * Add navigations
	 */
	public function addNavigations() {
		register_nav_menus([
			'primary' => __('Primary Menu', 'sha'),
			'footer' => __('Footer Menu', 'sha'),
		]);
	}

	public function cleanHead() {
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
	}

	public function humansTxt() {
		echo '<link type="text/plain" rel="author" href="' . trailingslashit(get_template_directory_uri()) . 'humans.txt" />';
	}

	public function setTimezone() {
		if (get_option('timezone_string') !== '') {
			date_default_timezone_set(get_option('timezone_string'));
		}
	}

	/**
	 * Adds a JS script to the head that removes 'no-js' from the html class list
	 */
	public function noJsScript() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}

	/**
	 * Checks if the browser supports css grid and adds "browser-outdated"-class to the html
	 */
	public function browserOutdatedScript() {
		echo "<script>(function(html){if(typeof document.createElement('div').style.grid !== 'string'){html.className = html.className + ' browser-outdated'}})(document.documentElement);</script>\n";
	}

	public function browserRequirements() {
		printf('<noscript>
			<div class="browser-check browser-check--noscript">
				<p>%1$s</p>
			</div>
		</noscript>
		<div class="browser-check browser-check--outdated">
			<p>%2$s;</p>
		</div>',
			__('JavaScript seems to be disabled. Some functionalities might not work correctly.', 'sht'),
			sprintf(_x('You are using an outdated browser. Please update your browser to view this website correctly: %s', 'translators: %s = Link to browsehappy.org', 'sht'), '<a href="https://browsehappy.com/">https://browsehappy.com/</a>')
		);
	}
}
