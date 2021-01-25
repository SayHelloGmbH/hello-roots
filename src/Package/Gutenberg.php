<?php

namespace SayHello\Theme\Package;

/**
 * Adjustments for the Gutenberg Editor
 *
 * @author Nico Martin <nico@sayhello.ch>
 */
class Gutenberg
{
	public $min = false;
	public $js = false;
	public $admin_font_url = false;
	public $admin_font_path = false;
	public $colors = [];
	public $allowedCoreBlocks = [
		'core/paragraph',
		'core/image',
		'core/heading',
		'core/list',
		'core/shortcode',
	];

	public function __construct()
	{
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = true;
		}

		if (file_exists(get_template_directory() . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js')) {
			$this->js = get_template_directory_uri() . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js';
		}

		if (file_exists(get_template_directory() . '/assets/fonts/fonts-woff2.css')) {
			$this->admin_font_path = get_template_directory() . '/assets/fonts/fonts-woff2.css';
			$this->admin_font_url = get_template_directory_uri() . '/assets/fonts/fonts-woff2.css';
		}
	}

	public function run()
	{
		if (!function_exists('register_block_type')) {
			return; // Gutenberg is not active.
		}
		add_action('enqueue_block_editor_assets', [$this, 'enqueueBlockAssets']);
		add_filter('block_categories', [$this, 'blockCategories']);
		add_filter('block_editor_settings', [$this, 'editorSettings']);
		add_action('after_setup_theme', [$this, 'themeSupports']);
		add_action('after_setup_theme', [$this, 'colorPalette']);
		add_action('init', [$this, 'setScriptTranslations']);
		add_action('init', [$this, 'addBlockPatternCategory']);

		add_filter('admin_body_class', [$this, 'extendAdminBodyClass']);
		add_action('admin_menu', [$this, 'reusableBlocksAdminMenu']);
	}

	/**
	 * Allow the Theme to use additional core features
	 * See https://github.com/SayHelloGmbH/hello-roots/wiki/Gutenberg#theme-colours for information on how to
	 * load the colours and text sizes from your settings.json into Gutenberg
	 */
	public function themeSupports()
	{
		add_theme_support('align-wide');

		// Hide the free number field
		add_theme_support('disable-custom-font-sizes');

		// Hide the selectable text sizes
		add_theme_support('editor-font-sizes', []);

		// Since WordPress 5.5: DISALLOW block patterns delivered by Core
		// (We can add our own to the pattern category sht-block-patterns)
		remove_theme_support('core-block-patterns');
	}

	/**
	 * Read in the gutenberg_colors array from the settings.json file
	 * and add these colors to the Gutenberg color palette
	 * @return void
	 */
	public function colorPalette()
	{
		$settings = sht_theme()->getSettings();

		if (isset($settings['gutenberg_colors'])) {
			$colors = [];

			foreach ($settings['gutenberg_colors'] as $color_key => $color) {
				foreach ($color as $variation_key => $variation) {
					$colors[] = [
						'name' => $variation_key === 'base' ? ucfirst($color_key) : implode(' ', [ucfirst($color_key), $variation_key]),
						'slug' => $variation_key === 'base' ? $color_key : implode(' ', [$color_key, $variation_key]),
						'color' => $color[$variation_key]
					];
				}
			}

			if (!empty($colors)) {
				add_theme_support('editor-color-palette', $colors);
				foreach ($colors as $color) {
					$this->colors[sanitize_title($color['slug'])] = $color;
				}
			}
		}

		// Removes gradient feature
		add_theme_support('disable-custom-gradients', true);
		add_theme_support('editor-gradient-presets', []);

		// Adds custom gradient (replace line above with this line to use)
		// add_theme_support('editor-gradient-presets', [
		// 	[
		// 		'name'     => __('Test', 'sht'),
		// 		'gradient' => 'linear-gradient(180deg, red, orange)',
		// 		'slug'     => 'test'
		// 	]
		// ]);
	}

	/**
	 * Gutenberg enqueues a few styles within an inline STYLE block in the
	 * editor. This removes them. (The default Gutenberg implementation
	 * currently only contains a few basic typography settings.)
	 * @param  array $editor_settings The pre-defined settings
	 * @return array                  The modified settings
	 */
	public function editorSettings($editor_settings)
	{
		$editor_settings['styles'] = [];
		return $editor_settings;
	}

	public function enqueueBlockAssets()
	{
		if ($this->js) {
			$script_asset_path = get_template_directory() . '/assets/gutenberg/blocks.asset.php';
			$script_asset = file_exists($script_asset_path) ? require($script_asset_path) : ['dependencies' => [], 'version' => sht_theme()->version];
			wp_enqueue_script(
				sht_theme()->prefix . '-gutenberg-script',
				$this->js,
				$script_asset['dependencies'],
				$script_asset['version']
			);
		}
		if ($this->admin_font_url) {
			wp_enqueue_style(sht_theme()->prefix . '-gutenberg-font', $this->admin_font_url, [], filemtime($this->admin_font_path));
		}
	}

	/**
	 * https://github.com/SayHelloGmbH/hello-roots/wiki/Translation-in-JavaScript
	 *
	 * Make sure that the JSON files are at e.g.
	 * 'languages/sht-de_DE_formal-739d784e82179214dfd2a6c345374e30.json' or
	 * 'languages/sht-fr_FR-739d784e82179214dfd2a6c345374e30.json'
	 *
	 * mhm 28.1.2020
	 */
	public function setScriptTranslations()
	{
		wp_set_script_translations(sht_theme()->prefix . '-gutenberg-script', 'sht', get_template_directory() . '/languages');
	}

	public function blockCategories($categories)
	{
		return array_merge($categories, [
			[
				'slug'  => 'sht/blocks',
				'title' => _x('Blöcke von Say Hello', 'Custom block category name', 'sha'),
			],
		]);
	}

	public function reusableBlocksAdminMenu()
	{
		add_submenu_page(
			'themes.php',
			_x('Wiederverwendbare Blöcke', 'Admin page title', 'sht'),
			_x('Wiederverwendbare Blöcke', 'Admin menu label', 'sht'),
			'edit_posts',
			'edit.php?post_type=wp_block'
		);
	}

	public function isContextEdit()
	{
		return array_key_exists('context', $_GET) && $_GET['context'] === 'edit';
	}

	/**
	 * Get a context-aware image wrapped in a FIGURE tag. If frontend, it'll be a lazyimage.
	 */
	public function getLazyImage($post_id, $size, $figure_class, $image_class)
	{
		if ($this->isContextEdit()) {
			$featured_image = wp_get_attachment_image(get_post_thumbnail_id($post_id), $size, false, ['class' => $image_class]);
			if (!empty($featured_image)) {
				$featured_image = '<figure class="' . $figure_class . '">' . $featured_image . '</figure>';
			}
		} else {
			$featured_image = sht_theme()->Package->Lazysizes->getLazyImage(get_post_thumbnail_id($post_id), $size, $figure_class, $image_class);
		}
		return $featured_image;
	}

	/**
	 * Add a CSS class name to the admin body, containing current post
	 * name and post type.
	 * @param  string $classes The pre-existing body class name/s
	 * @return string
	 */
	public function extendAdminBodyClass($classes)
	{
		global $post;
		if ($post->post_type ?? false && $post->post_name ?? false) {
			global $post;
			$classes .= ' post-type-' . $post->post_type . ' post-type-' . $post->post_type . '--' . $post->post_name;
		}
		return $classes;
	}

	public function addBlockPatternCategory()
	{
		if (function_exists('register_block_pattern_category')) {
			register_block_pattern_category('sht-block-patterns', ['label' => __('Say Hello', 'sht')]);
		}
	}
}
