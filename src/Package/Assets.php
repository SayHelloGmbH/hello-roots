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

	public function __construct()
	{
		$this->font_version = sht_theme()->version;
	}

	public function run()
	{
		add_action('wp_enqueue_scripts', [ $this, 'registerAssets' ]);
		add_action('admin_enqueue_scripts', [ $this, 'registerAdminAssets' ]);
		add_action('admin_init', [ $this, 'editorStyle' ]);
		add_action('wp_head', [ $this, 'loadFonts' ]);
		add_action('sht_after_body_open', [ $this, 'loadSvgFilter' ]);
	}

	public function registerAssets()
	{

		if (!is_user_logged_in()) {
			wp_deregister_style('dashicons');
		}

		// CSS
		$deps = ['wp-block-library'];
		wp_enqueue_style('fancybox', get_template_directory_uri() . '/assets/plugins/fancybox/jquery.fancybox.min.css', [], '3.4.0');
		$deps[] = 'fancybox';
		wp_enqueue_style(sht_theme()->prefix . '-style', get_template_directory_uri() . '/assets/styles/ui' . (sht_theme()->debug ? '' : '.min') . '.css', $deps, filemtime(get_template_directory() .'/assets/styles/ui' . (sht_theme()->debug ? '' : '.min') . '.css'));

		// JavaScript
		$deps = [];
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/scripts/jquery-3.2.1.min.js', [], '3.2.1', false);
		$deps[] = 'jquery';

		wp_enqueue_script('fancybox', get_template_directory_uri() . '/assets/plugins/fancybox/jquery.fancybox.min.js', [ 'jquery' ], '3.4.0', true);
		$deps[] = 'fancybox';

		wp_enqueue_script(sht_theme()->prefix . '-script', get_template_directory_uri() . '/assets/scripts/ui' . (sht_theme()->debug ? '' : '.min') . '.js', $deps, filemtime(get_template_directory() . '/assets/scripts/ui' . (sht_theme()->debug ? '' : '.min') . '.js'), true);

		if (function_exists('acf_get_setting')) {
			wp_localize_script(sht_theme()->prefix . '-script', 'sht_map_data', [
				'google_api_key' => acf_get_setting('google_api_key'),
			]);
		}

		// Comment in if you need to access the REST API from your scripts
		// wp_localize_script(sht_theme()->prefix . '-script', 'sht_wp_api', array(
		// 	'root' => esc_url_raw(rest_url()),
		// 	'nonce' => wp_create_nonce('wp_rest'),
		// 	'uid' => get_current_user_id()
		// ));
	}

	public function registerAdminAssets()
	{
		// CSS
		wp_enqueue_style(sht_theme()->prefix . '-admin-editor-style', get_template_directory_uri() . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css', ['wp-edit-blocks'], filemtime(get_template_directory() . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css'));
		wp_enqueue_style(sht_theme()->prefix . '-admin-style', get_template_directory_uri() . '/assets/styles/admin' . (sht_theme()->debug ? '' : '.min') . '.css', [sht_theme()->prefix . '-admin-editor-style', 'wp-edit-blocks'], filemtime(get_template_directory() . '/assets/styles/admin' . (sht_theme()->debug ? '' : '.min') . '.css'));

		// Javascript
		wp_enqueue_script(sht_theme()->prefix . '-admin-script', get_template_directory_uri() . '/assets/scripts/admin' . (sht_theme()->debug ? '' : '.min') . '.js', [], filemtime(get_template_directory() . '/assets/scripts/admin' . (sht_theme()->debug ? '' : '.min') . '.js'), true);
		if (function_exists('acf_get_setting')) {
			wp_localize_script(sht_theme()->prefix . '-admin-script', 'sht_map_data', [
				'google_api_key' => acf_get_setting('google_api_key'),
			]);
		}
	}

	public function editorStyle()
	{
		if (file_exists(get_template_directory() . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css')) {
			add_editor_style(get_template_directory_uri() . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css');
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

	public function loadSvgFilter()
	{
		get_template_part('partials/svg/svg-filter');
	}
}
