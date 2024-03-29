<?php

namespace SayHello\Theme\Package;

/**
 * Assets (CSS, JavaScript etc)
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Assets
{

	private $font_version = '1.0';
	private $min = true;

	public function __construct()
	{
		$this->font_version = sht_theme()->version;

		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = false;
		}
	}

	public function run()
	{
		add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
		add_action('admin_enqueue_scripts', [$this, 'registerAdminAssets']);
		add_action('wp_head', [$this, 'loadFonts']);
	}

	public function registerAssets()
	{

		if (!is_user_logged_in()) {
			wp_deregister_style('dashicons');
		}

		// CSS
		$deps_css = [];

		if (class_exists('GFForms')) {
			$deps_css[] = 'gform_basic';
			$deps_css[] = 'gform_theme';
		}

		wp_enqueue_style(sht_theme()->prefix . '-style', get_template_directory_uri() . '/assets/styles/ui' . ($this->min ? '.min' : '') . '.css', $deps_css, filemtime(get_template_directory() . '/assets/styles/ui' . ($this->min ? '.min' : '') . '.css'));

		// JavaScript
		$deps_js = [];

		wp_enqueue_script(sht_theme()->prefix . '-script', get_template_directory_uri() . '/assets/scripts/ui' . ($this->min ? '.min' : '') . '.js', $deps_js, filemtime(get_template_directory() . '/assets/scripts/ui' . ($this->min ? '.min' : '') . '.js'), true);

		wp_localize_script(sht_theme()->prefix . '-script', 'sht_theme', [
			'version' => wp_get_theme()->get('Version'),
			'directory_uri' => get_template_directory_uri(),
		]);

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
		wp_enqueue_style(sht_theme()->prefix . '-admin-editor-style', get_template_directory_uri() . '/assets/styles/admin-editor' . ($this->min ? '.min' : '') . '.css', ['wp-edit-blocks'], filemtime(get_template_directory() . '/assets/styles/admin-editor' . ($this->min ? '.min' : '') . '.css'));
		wp_enqueue_style(sht_theme()->prefix . '-admin-style', get_template_directory_uri() . '/assets/styles/admin' . ($this->min ? '.min' : '') . '.css', [sht_theme()->prefix . '-admin-editor-style', 'wp-edit-blocks'], filemtime(get_template_directory() . '/assets/styles/admin' . ($this->min ? '.min' : '') . '.css'));

		// Javascript
		// wp_enqueue_script(sht_theme()->prefix . '-admin-script', get_template_directory_uri() . '/assets/scripts/admin' . ($this->min ? '.min' : '') . '.js', [], filemtime(get_template_directory() . '/assets/scripts/admin' . ($this->min ? '.min' : '') . '.js'), true);
		// if (function_exists('acf_get_setting')) {
		// 	wp_localize_script(sht_theme()->prefix . '-admin-script', 'sht_map_data', [
		// 		'google_api_key' => acf_get_setting('google_api_key'),
		// 	]);
		// }
	}

	public function loadFonts()
	{

		$font_version = $this->getSetting('theme_fontver');
		if ($font_version) {
			$this->font_version = $font_version;
		}

		$theme_url = str_replace(get_home_url(), '', get_template_directory_uri());
		$font_name = sanitize_title(sht_theme()->name) . '-font-' . $this->font_version;

		$file = get_template_directory() . '/assets/scripts/loadfonts.js';
		if (!file_exists($file)) {
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
	 * This function returns the settings value from assets/settings.json
	 *
	 * @param string $setting	The name of the setting to fetch
	 * @param string $filename	Optional, name/path of file.
	 * @return mixed
	 */
	public function getSetting(string $setting, string $filename = 'assets/settings.json')
	{
		$path = trailingslashit(get_template_directory()) . $filename;
		if (!is_file($path)) {
			return false;
		}

		$settings = json_decode(file_get_contents($path), true);
		if (!array_key_exists($setting, $settings)) {
			return false;
		}

		return $settings[$setting];
	}
}
