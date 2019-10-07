<?php

namespace SayHello\Theme\Package;

/**
 * Assets (CSS, JavaScript etc)
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Assets
{

	public $font_version = '1.0';
	public $theme_url = '';
	public $theme_path = '';

	public function __construct()
	{
		$this->font_version = sht_theme()->version;
		$this->theme_url    = get_template_directory_uri();
		$this->theme_path   = get_template_directory();
	}

	public function run()
	{
		add_action('wp_enqueue_scripts', [ $this, 'registerAssets' ]);
		add_action('admin_enqueue_scripts', [ $this, 'registerAdminAssets' ]);
		add_action('admin_init', [ $this, 'editorStyle' ]);
		add_action('wp_head', [ $this, 'loadFonts' ]);
	}

	public function registerAssets()
	{

		if (! is_user_logged_in()) {
			wp_deregister_style('dashicons');
		}

		$theme_version = sht_theme()->version;

		$min = true;
		if (sht_theme()->debug && is_user_logged_in()) {
			$min = false;
		}

		/**
		 * CSS
		 */
		$deps = ['wp-block-library'];
		wp_enqueue_style('fancybox', $this->theme_url . '/assets/plugins/fancybox/jquery.fancybox.min.css', [], '3.4.0');
		$deps[] = 'fancybox';
		wp_enqueue_style(sht_theme()->prefix . '-style', $this->theme_url . '/assets/styles/ui' . ($min ? '.min' : '') . '.css', $deps, $theme_version);

		/**
		 * Javascript
		 */
		$deps = [];
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', $this->theme_url . '/assets/scripts/jquery-3.2.1.min.js', [], '3.2.1', false);
		$deps[] = 'jquery';

		if (file_exists($this->theme_path . '/assets/scripts/modernizr/ui-modernizr.min.js')) {
			wp_enqueue_script('ui-modernizr', $this->theme_url . '/assets/scripts/modernizr/ui-modernizr.min.js', [], $theme_version, true);
			$deps[] = 'ui-modernizr';
		}

		wp_enqueue_script('fancybox', $this->theme_url . '/assets/plugins/fancybox/jquery.fancybox.min.js', [ 'jquery' ], '3.4.0', true);
		$deps[] = 'fancybox';
		wp_enqueue_script(sht_theme()->prefix . '-script', $this->theme_url . '/assets/scripts/ui' . ($min ? '.min' : '') . '.js', $deps, $theme_version, true);

		/**
		 * Footer JS
		 */
		$defaults = [
			'GeneralError' => sht_theme()->error,
			'AjaxURL'      => admin_url('admin-ajax.php'),
			'homeurl'      => get_home_url(),
			'templateurl'  => get_template_directory_uri(),
		];

		$vars = json_encode(apply_filters('sht_footer_js', $defaults));
		wp_add_inline_script(sht_theme()->prefix . '-script', "var ThemeJSVars = {$vars};", 'before');
	}

	public function registerAdminAssets()
	{

		$theme_version = sht_theme()->version;

		if (file_exists($this->theme_path . '/assets/scripts/modernizr/admin-modernizr.min.js')) {
			wp_enqueue_script(sht_theme()->prefix . '-admin-script', $this->theme_url . '/assets/scripts/modernizr/admin-modernizr.min.js', [], $theme_version, true);
		}

		wp_enqueue_style(sht_theme()->prefix . '-admin-editor-style', $this->theme_url . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css', ['wp-edit-blocks'], $theme_version);
		wp_enqueue_style(sht_theme()->prefix . '-admin-style', $this->theme_url . '/assets/styles/admin' . (sht_theme()->debug ? '' : '.min') . '.css', [sht_theme()->prefix . '-admin-editor-style', 'wp-edit-blocks'], $theme_version);

		wp_enqueue_script(sht_theme()->prefix . '-admin-script', $this->theme_url . '/assets/scripts/admin' . (sht_theme()->debug ? '' : '.min') . '.js', [], $theme_version, true);

		/**
		 * Admin Footer JS
		 */
		$defaults = [
			'GeneralError' => sht_theme()->error,
			'AjaxURL'      => admin_url('admin-ajax.php'),
			'homeurl'      => get_home_url(),
			'templateurl'  => get_template_directory_uri(),
		];

		$vars = json_encode(apply_filters('sht_admin_footer_js', $defaults));
		wp_add_inline_script(sht_theme()->prefix . '-admin-script', "var SayHelloVars = {$vars};", 'before');
	}

	public function editorStyle()
	{
		if (file_exists($this->theme_path . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css')) {
			add_editor_style($this->theme_url . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css');
		}
	}

	public function loadFonts()
	{

		$fontver = $this->getSetting('theme_fontver');
		if ($fontver) {
			$this->font_version = $fontver;
		}

		$theme_url = str_replace(get_home_url(), '', get_template_directory_uri());
		$font_name = sanitize_title(sht_theme()->name) . '-font-' . $this->font_version;

		$file = get_template_directory() . '/assets/scripts/loadfonts.min.js';
		if (! file_exists($file)) {
			echo 'loadfonts.min.js not found!';
			die;
		}

		echo '<script id="loadFonts">';
		echo file_get_contents($file);
		echo "loadFont('$font_name', '$theme_url/assets/fonts/fonts-woff.css', '$theme_url/assets/fonts/fonts-woff2.css');";
		echo '</script>';
		echo '<noscript>';
		echo "<link rel='stylesheet' id='font' href='$theme_url/assets/fonts/fonts-woff.css' type='text/css' media='all'>";
		echo '</noscript>';
	}

	/**
	 * This function returns the settings value from assets/settings.js
	 *
	 * @since 0.1.0
	 *
	 * @param string $setting settings key
	 *
	 * @return string | bool
	 */
	public function getSetting($setting)
	{
		$path = trailingslashit(get_template_directory()) . 'assets/settings.json';
		if (! is_file($path)) {
			return false;
		}

		$settings = json_decode(file_get_contents($path), true);
		if (! array_key_exists($setting, $settings)) {
			return false;
		}

		return $settings[ $setting ];
	}
}
