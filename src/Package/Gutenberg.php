<?php

namespace SayHello\Theme\Package;

/**
 * Adjustments for the Gutenberg Editor
 *
 * @author Nico Martin <nico@sayhello.ch>
 */
class Gutenberg
{
	public $theme_url = '';
	public $theme_path = '';
	public $min = false;
	public $js = false;
	public $allowedCoreBlocks = [
		'core/paragraph',
		'core/image',
		'core/heading',
		'core/list',
		'core/shortcode',
	];

	public function __construct()
	{
		$this->theme_url  = get_template_directory_uri();
		$this->theme_path = get_template_directory();
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = true;
		}

		if (file_exists($this->theme_path . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js')) {
			$this->js = $this->theme_url . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js';
		}
	}

	public function run()
	{
		if (!function_exists('register_block_type')) {
			return; // Gutenberg is not active.
		}
		add_action('wp_print_styles', [$this, 'removeCoreBlockCSS'], 100);
		add_action('enqueue_block_editor_assets', [$this, 'enqueueBlockAssets']);
		add_filter('block_categories', [$this, 'blockCategories']);
		add_filter('sht_disabled_blocks', [$this, 'disableCoreBlockTypes']);
		add_action('after_setup_theme', [$this, 'themeSupports']);
	}

	/**
	 * Allow the Theme to use additional core features
	 * See https://github.com/SayHelloGmbH/hello-roots/wiki/Gutenberg#theme-colours for information on how to
	 * load the colours from your settings.json into Gutenberg
	 */
	public function themeSupports()
	{
		add_theme_support('align-wide');
		add_theme_support('editor-color-palette'); // Disable the standard colour palette
		add_theme_support('disable-custom-colors'); // Disable the custom colour palette
	}

	public function removeCoreBlockCSS()
	{
		wp_deregister_style('wp-block-library');
	}

	public function enqueueBlockAssets()
	{
		if ($this->js) {
			wp_enqueue_script(sht_theme()->prefix . '-gutenberg-script', $this->js, ['wp-blocks', 'wp-element', 'wp-edit-post', 'lodash'], sht_theme()->version);
			$vars = json_encode(apply_filters('sht_disabled_blocks', []));
			wp_add_inline_script(sht_theme()->prefix . '-gutenberg-script', "var shtDisabledBlocks = {$vars};", 'before');
		}
	}

	public function blockCategories($categories)
	{
		return array_merge($categories, [
			[
				'slug'  => 'sht/blocks',
				'title' => __('Blocks by Say Hello', 'sha'),
			],
		]);
	}

	/**
	 * Pass an array of disallowed Block types to the Gutenberg JavaScript
	 *
	 * @param  array $blockTypes The pre-defined array of allowed block types
	 *
	 * @return array             The potentially modified array of allowed block types
	 *
	 * @todo: Filter by current post type: e.g. Cover allowed on page but not Post. mhm 13.5.2019
	 */
	public function disableCoreBlockTypes(array $allowed_types)
	{
		$coreBlocks = [
			'core/audio',
			'core/code',
			'core/cover',
			'core/embed',
			'core/file',
			'core/html',
			'core/quote',
			'core/rss',
			'core/search',
			'core/table',
			'core/video',
			/**
			 * Formatting
			 */
			'core/freeform',
			'core/preformatted',
			'core/verse',
			/**
			 * Layout
			 */
			'core/button',
			'core/columns',
			'core/media-text',
			'core/more',
			'core/nextpage',
			'core/pullquote',
			'core/separator',
			'core/spacer',
			/**
			 * Widgets
			 */
			'core/archives',
			'core/calendar',
			'core/categories',
			'core/latest-comments',
			'core/latest-posts',
			'core/tag-cloud',
			/**
			 * Embeds
			 */
			'core-embed/amazon-kindle',
			'core-embed/animoto',
			'core-embed/cloudup',
			'core-embed/collegehumor',
			'core-embed/crowdsignal',
			'core-embed/dailymotion',
			'core-embed/facebook',
			'core-embed/flickr',
			'core-embed/hulu',
			'core-embed/imgur',
			'core-embed/instagram',
			'core-embed/issuu',
			'core-embed/kickstarter',
			'core-embed/meetup-com',
			'core-embed/mixcloud',
			'core-embed/polldaddy',
			'core-embed/reddit',
			'core-embed/reverbnation',
			'core-embed/screencast',
			'core-embed/scribd',
			'core-embed/slideshare',
			'core-embed/smugmug',
			'core-embed/soundcloud',
			'core-embed/speaker',
			'core-embed/speaker-deck',
			'core-embed/spotify',
			'core-embed/ted',
			'core-embed/tumblr',
			'core-embed/twitter',
			'core-embed/videopress',
			'core-embed/vimeo',
			'core-embed/wordpress',
			'core-embed/wordpress-tv',
			'core-embed/youtube',
		];

		$disallowed_types = [];
		foreach ($coreBlocks as $block) {
			if (!in_array($block, $this->allowedCoreBlocks)) {
				$disallowed_types[] = $block;
			}
		}

		return array_merge($allowed_types, $disallowed_types);
	}
}
