<?php

namespace HelloTheme;

/**
 * This Class represents the Basic Object of the Theme
 */
class ThemeInstance {

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
	public $pfx = '';

	/**
	 * Error message
	 * @var string
	 */
	public $error = 'An unexpected error occured.';

	/**
	 * Debug mode
	 * @var bool
	 */
	public $debug = false;

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 * @return object       The class instance.
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ThemeInstance ) ) {

			self::$instance = new ThemeInstance;

			$theme = wp_get_theme();

			self::$instance->name    = $theme->name;
			self::$instance->version = $theme->version;
			self::$instance->pfx     = 'sht';
			self::$instance->error   = __( 'An unexpected error occured.', 'sht' );

			self::$instance->debug = true;
			if ( strpos( $_SERVER['HTTP_HOST'], '.hello' ) === false && ! in_array( $_SERVER['REMOTE_ADDR'], [ '127.0.0.1', '::1' ] ) ) {
				self::$instance->debug = false;
			}
		}

		return self::$instance;
	}

	/**
	 * Run function
	 */
	public function run() {
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_action( 'wp_head', [ $this, 'no_js_script' ] );
		add_action( 'wp_head', [ $this, 'browser_outdated_script' ] );
		add_action( 'wp_footer', [ $this, 'browser_requirements' ], 100 );
		add_filter( 'upload_mimes', [ $this, 'add_svg_support' ] );
		add_action( 'after_setup_theme', [ $this, 'theme_setup' ] );

		/**
		 * Hidden/Hover admin bar
		 */
		add_action( 'get_header', [ $this, 'remove_admin_bar_styles' ] );
		add_action( 'wp_head', [ $this, 'custom_admin_bar_styles' ] );
	}

	/**
	 * @param $classes array of body classes
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		if ( sht_theme()->debug ) {
			$classes[] = 'theme-dev';
		}

		return $classes;
	}

	/**
	 * Adds a JS script to the head that removes 'no-js' from the html class list
	 */
	public function no_js_script() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}

	/**
	 * Checks if the browser supports css grid and adds "browser-outdated"-class to the html
	 */
	public function browser_outdated_script() {
		echo "<script>(function(html){if(typeof document.createElement('div').style.grid !== 'string'){html.className = html.className + ' browser-outdated'}})(document.documentElement);</script>\n";
	}

	/**
	 * Prints some browser check elements to the footer
	 */
	public function browser_requirements() {
		?>
		<noscript>
			<div class="browser-check browser-check--noscript">
				<p><?php _e( 'JavaScript seems to be disabled. Some functionalities might not work correctly.', 'sht' ); ?></p>
			</div>
		</noscript>
		<div class="browser-check browser-check--outdated">
			<p>
				<?php
				// translators: %s = Link to browsehappy.org
				printf( __( 'You are using an outdated browser. Please update your browser to view this website correctly: %s', 'sht' ), '<a href="https://browsehappy.com/">https://browsehappy.com/</a>' );
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * @param $mimes array of allowed mime types for media center
	 *
	 * @return array
	 */
	public function add_svg_support( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * General Theme Setup
	 */
	public function theme_setup() {

		add_theme_support( 'custom-logo', [
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		] );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );

		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		if ( get_option( 'timezone_string' ) != '' ) {
			date_default_timezone_set( get_option( 'timezone_string' ) );
		}
	}

	/**
	 * Removes admin bar styles
	 */
	public function remove_admin_bar_styles() {
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}

	/**
	 * adds custom admin bar styles
	 */
	public function custom_admin_bar_styles() {
		?>
		<style id="sayhello-adminbar-fix" type="text/css">
			#wpadminbar {
				top: -30px;
				height: 40px;
				background: none;
				-webkit-transition: top 0.1s ease-out;
				-moz-transition: top 0.1s ease-out;
				-o-transition: top 0.1s ease-out;
				transition: top 0.1s ease-out;
			}

			#wpadminbar:hover {
				top: 0;
			}

			#wp-toolbar {
				background: #23282d;
				height: 32px;
			}

			@media screen and (max-width: 782px) {
				html #wpadminbar {
					top: -46px;
					height: 50px;
				}

				html #wp-toolbar {
					height: 46px;
				}
			}
		</style>
		<?php
	}
}
