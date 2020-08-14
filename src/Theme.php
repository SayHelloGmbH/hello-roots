<?php

namespace SayHello\Theme;

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

	public function __construct()
	{
		$this->theme = wp_get_theme();
	}

	public function run()
	{
		$this->loadClasses(
			[
				\SayHello\Theme\Package\Helpers::class,
				\SayHello\Theme\Package\ACF::class,
				\SayHello\Theme\Package\Assets::class,
				\SayHello\Theme\Package\Archives::class,
				\SayHello\Theme\Package\BodyClass::class,
				\SayHello\Theme\Package\CustomPages::class,
				\SayHello\Theme\Package\Error::class,
				\SayHello\Theme\Package\Gutenberg::class,
				\SayHello\Theme\Package\Language::class,
				\SayHello\Theme\Package\Lazysizes::class,
				\SayHello\Theme\Package\LoginScreen::class,
				\SayHello\Theme\Package\Media::class,
				\SayHello\Theme\Package\Navigation::class,
				\SayHello\Theme\Package\Shyify::class,
				\SayHello\Theme\Package\Sidebars::class,
				\SayHello\Theme\Package\SVG::class,
				\SayHello\Theme\Package\ThemeOptions::class,
				\SayHello\Theme\Package\View::class,

				\SayHello\Theme\PostType\Page::class,
				\SayHello\Theme\PostType\Post::class,
			]
		);

		add_action('after_setup_theme', [ $this, 'themeSupports' ]);
		add_action('after_setup_theme', [ $this, 'contentWidth' ]);
		add_action('comment_form_before', [$this, 'enqueueReplyScript']);

		add_action('wp_head', [ $this, 'noJsScript' ]);
		add_action('wp_head', [ $this, 'setResolutionCookie' ]);
		add_action('wp_head', [ $this, 'humansTxt' ]);

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
		if (! isset(self::$instance) && ! (self::$instance instanceof Theme)) {
			self::$instance = new Theme;

			self::$instance->name    = self::$instance->theme->name;
			self::$instance->version = self::$instance->theme->version;
			self::$instance->prefix  = 'sht';
			self::$instance->error   = _x('Ein unerwarteter Fehler ist geschehen.', 'Theme instance unexpected error', 'sht');
			self::$instance->debug   = true;

			if (! isset($_SERVER[ 'HTTP_HOST' ]) || (strpos($_SERVER[ 'HTTP_HOST' ], '.hello') === false && strpos($_SERVER[ 'HTTP_HOST' ], '.local') === false) && ! in_array($_SERVER[ 'REMOTE_ADDR' ], [ '127.0.0.1', '::1' ])) {
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
	private function loadClasses($classes)
	{
		foreach ($classes as $class) {
			$class_parts = explode('\\', $class);
			$class_short = end($class_parts);
			$class_set   = $class_parts[ count($class_parts) - 2 ];

			if (! isset(sht_theme()->{$class_set}) || ! is_object(sht_theme()->{$class_set})) {
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
	 * Set the content width based on the theme's design and stylesheet
	 */
	public function contentWidth()
	{
		$GLOBALS[ 'content_width' ] = apply_filters('sht/content_width', 640);
	}

	/**
	 * Allow the Theme to use additional core features
	 */
	public function themeSupports()
	{
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('custom-logo');
		add_theme_support('html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ]);
		add_theme_support('post-thumbnails', [ 'post' ]);
	}

	public function cleanHead()
	{
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
	}

	public function humansTxt()
	{
		echo '<link type="text/plain" rel="author" href="' . trailingslashit(get_template_directory_uri()) . 'humans.txt" />';
	}

	public function setResolutionCookie()
	{
		echo '<script>
			document.cookie="resolution="+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+"; path=/";
		</script>';
	}

	/**
	 * Adds a JS script to the head that removes 'no-js' from the html class list
	 */
	public function noJsScript()
	{
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>".chr(10);
	}

	public function getTemplatePart(string $file_path, ...$arguments)
	{
		$data = [];

		// Array containing possible paths to the template part
		$parts = (array) $file_path;

		if (is_array($arguments)) {
			// Find an array in $attributes and use it as $data in the
			// included template part
			foreach ($arguments as $attribute) {
				if (is_array($attribute) || $attribute instanceof WP_Post) {
					$data = $attribute;
					break;
				}
			}

			// If the first function attribute after $file_path is a string,
			// prepend the alternative (e.g. post type) name to the paths array
			// e.g. [partials/excerpt-customposttype, partials/excerpt]
			if (is_string($arguments[0] ?? null)) {
				array_unshift($parts, $file_path.'-'.$arguments[0]);
			}
		}

		// Make sure that each possible file path is suffixed with .php
		if (!empty($parts)) {
			foreach ($parts as &$file) {
				if (false === strpos($file, '.php')) {
					$file .= '.php';
				}
			}
			if (!empty($template = locate_template($parts))) {
				require(locate_template($parts));
			}
		}
	}

	public function enqueueReplyScript()
	{
		if (is_singular() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
