<?php

namespace SayHello\Theme\Package;

/**
 * Adjustments for the Gutenberg Editor
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Gutenberg
{
	public $min = true;
	public $js = false;
	public $admin_font_url = false;
	public $admin_font_path = false;

	public function __construct()
	{
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = false;
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
		add_action('after_setup_theme', [$this, 'editorStyle']);
		add_action('admin_init', [$this, 'disableBlockDirectory']);
		add_filter('block_categories_all', [$this, 'blockCategories']);

		add_action('after_setup_theme', [$this, 'themeSupports'], 10);

		add_action('init', [$this, 'setScriptTranslations']);
		add_action('init', [$this, 'addBlockPatternCategory']);

		add_filter('admin_body_class', [$this, 'extendAdminBodyClass']);
	}

	/**
	 * Allow the Theme to use additional core features
	 */
	public function themeSupports()
	{
		// Since WordPress 5.5: DISALLOW block patterns delivered by Core
		// (We can add our own to the pattern category sht-block-patterns)
		remove_theme_support('core-block-patterns');

		// Allows blocks to be set to full and wide.
		add_theme_support('align-wide');

		// Add support for custom units.
		// https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#support-custom-units
		add_theme_support('custom-units', []);

		// Load standard CSS from core.
		// (Optional.)
		// add_theme_support('wp-block-styles');
	}

	/**
	 * Called via the enqueue_block_editor_assets hook. This is for
	 * scripts and styles for the block editor UI, not for the content.
	 * Don't add CSS here.
	 *
	 * @return void
	 */
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
	 * Add stylesheet which is specifically targeted to the Gutenberg editor
	 *
	 * @return void
	 */
	public function editorStyle()
	{
		add_editor_style('assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css');
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

	public function disableBlockDirectory()
	{
		remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
	}
}
