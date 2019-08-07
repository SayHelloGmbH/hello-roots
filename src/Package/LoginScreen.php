<?php

namespace SayHello\Theme\Package;

use \WP_Customize_Color_Control;
use \WP_Customize_Upload_Control;

/**
 * Configuration for the Customizer in the admin area.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class LoginScreen
{

	public $wp_customize = null;

	public function run()
	{
		if (class_exists('WP_Customize_Control')) {
			add_action('customize_register', [ $this, 'customSections' ]);
		}
		add_action('login_head', [ $this, 'customizeLoginForm' ]);
		add_action('password_protected_login_head', [ $this, 'customizeLoginForm' ]);
		add_filter('login_headerurl', [ $this, 'loginLogoUrl' ]);
		add_filter('login_headertext', [ $this, 'loginLogoTitle' ]);
	}

	/**
	 * Adds a new section to use custom controls in the WordPress customiser
	 *
	 * @param WP_Customize_Manager $wp_customize - WP Manager
	 *
	 * @return void
	 */
	public function customSections(\WP_Customize_Manager $wp_customize)
	{
		$this->wp_customize = $wp_customize;
		if ($this->wp_customize) {
			$this->wp_customize->add_section(
				'theme_mods_loginpage',
				[
					'title'    => _x('Loginseite', 'The section title in the WordPress Customizer', 'sht'),
					'priority' => 200,
				]
			);
			$this->settingsLogin();
		}
	}

	// All settings for the login screen
	public function settingsLogin()
	{
		if ($this->wp_customize) {
			// Company logo for the website
			$this->wp_customize->add_setting('login_logo');
			$this->wp_customize->add_control(
				new WP_Customize_Upload_Control(
					$this->wp_customize,
					'login_logo',
					[
						'label'    => _x('Logo', 'Field description title in Customizer', 'sht'),
						'section'  => 'theme_mods_loginpage',
						'settings' => 'login_logo',
						'priority' => 60,
					]
				)
			);

			// Login screen background
			$this->wp_customize->add_setting(
				'login_background_colour',
				[
					'capability' => 'edit_theme_options',
					'default'    => '#f1f1f1',
				]
			);
			$this->wp_customize->add_control(
				new WP_Customize_Color_Control(
					$this->wp_customize,
					'login_background_colour',
					[
						'label'    => _x('Hintergrundfarbe', 'Field label in Customizer', 'sht'),
						'section'  => 'theme_mods_loginpage',
						'settings' => 'login_background_colour',
					]
				)
			);

			// Login button colour
			$this->wp_customize->add_setting(
				'login_button_colour',
				[
					'capability' => 'edit_theme_options',
					'default'    => '#0085ba',
				]
			);
			$this->wp_customize->add_control(
				new WP_Customize_Color_Control(
					$this->wp_customize,
					'login_button_colour',
					[
						'label'    => _x('Buttonfarbe', 'Field label in Customizer', 'sht'),
						'section'  => 'theme_mods_loginpage',
						'settings' => 'login_button_colour',
					]
				)
			);

			// Login link colour (on page)
			$this->wp_customize->add_setting(
				'login_link_colour',
				[
					'capability' => 'edit_theme_options',
					'default'    => '#555d66',
				]
			);
			$this->wp_customize->add_control(
				new WP_Customize_Color_Control(
					$this->wp_customize,
					'login_link_colour',
					[
						'label'    => _x('Farbe für Links', 'Field label in Customizer', 'sht'),
						'section'  => 'theme_mods_loginpage',
						'settings' => 'login_link_colour',
					]
				)
			);

			// Login logo size
			$this->wp_customize->add_setting(
				'login_logo_size',
				[
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => [ $this, 'sanitizeAbsint' ],
					'default'           => 320,
				]
			);
			$this->wp_customize->add_control(
				'login_logo_size',
				[
					'type'        => 'number',
					'section'     => 'theme_mods_loginpage',
					'label'       => _x('Breite des Logos', 'Field label in Customizer', 'sht'),
					'description' => _x('(Pixelgrösse)', 'Field label in Customizer', 'sht'),
				]
			);
		}
	}

	// Make sure that the value is a boolean
	public function sanitizeCheckbox($checked)
	{
		return ((isset($checked) && true == $checked) ? true : false);
	}

	// Make sure that the value is an absolute integer
	public function sanitizeAbsint($number, $setting)
	{
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint($number);

		// If the input is an absolute integer, return it; otherwise, return the default
		return ($number ? $number : $setting->default);
	}

	// Adds inline CSS to the login form page
	// if the appropriate theme mods are set
	public function customizeLoginForm()
	{
		$theme_mods = get_theme_mods();

		$css = [];
		if (isset($theme_mods[ 'login_logo' ])) {
			$css[] = '.login h1 a {background: url(\'' . $theme_mods[ 'login_logo' ] . '\') center/contain no-repeat;}';
			$css[] = '.login h1 a {width: ' . get_theme_mod('login_logo_size', 320) . 'px}';
		}
		if (isset($theme_mods[ 'login_background_colour' ])) {
			$css[] = 'body {background-color: ' . $theme_mods[ 'login_background_colour' ] . ';}';
		}
		if (isset($theme_mods[ 'login_button_colour' ])) {
			$css[] = '.login .button-primary {background-color: ' . $theme_mods[ 'login_button_colour' ] . ';border: none;text-shadow: none;box-shadow: none;transition:all 300ms ease-in-out}';
			$css[] = '.login .button-primary:hover {background-color: ' . $theme_mods[ 'login_button_colour' ] . ';box-shadow: 0 0 .5rem ' . self::boxshadow($theme_mods[ 'login_button_colour' ]) . '}';
		}
		if (isset($theme_mods[ 'login_link_colour' ])) {
			$css[] = '.login #backtoblog a, .login #backtoblog a:hover, .login #nav a, .login #nav a:hover {color: ' . $theme_mods[ 'login_link_colour' ] . ';transition:all 300ms ease-in-out}';
			$css[] = '.login #backtoblog a:hover, .login #nav a:hover {opacity: .8}';
			$css[] = '.login a, .login a:hover {color: ' . $theme_mods[ 'login_link_colour' ] . ';transition:all 300ms ease-in-out}';
			$css[] = '.login a:hover {opacity: .8}';
		}
		if (! empty($css)) {
			echo '<style>' . implode(chr(10), $css) . '</style>';
		}
	}

	// Customize the link on the login page logo
	public function loginLogoUrl()
	{
		return home_url();
	}

	// Customize the link title text on the login page logo
	public function loginLogoTitle()
	{
		return get_bloginfo('name');
	}

	// Calculate a semi-transparent RGBA colour value from a hex value
	private static function boxshadow($hex)
	{
		return self::hex2rgba(str_replace('#', '#FF', $hex));
	}

	private static function hex2rgba($hex)
	{
		$hex = str_replace('#', '', $hex);

		switch (strlen($hex)) {
			case 3:
				$red   = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
				$green = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
				$blue  = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
				$alpha = 1;
				break;
			case 6:
				$red   = hexdec(substr($hex, 0, 2));
				$green = hexdec(substr($hex, 2, 2));
				$blue  = hexdec(substr($hex, 4, 2));
				$alpha = 1;
				break;
			case 8:
				$alpha = hexdec(substr($hex, 0, 2)) / 255;
				$red   = hexdec(substr($hex, 2, 2));
				$green = hexdec(substr($hex, 4, 2));
				$blue  = hexdec(substr($hex, 6, 2));
				break;
		}
		$rgba = array( $red, $green, $blue, $alpha );

		return 'rgba(' . implode(', ', $rgba) . ')';
	}
}
