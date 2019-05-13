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
	public $min = true;
	public $css = false;
	public $js = false;
	public $customTypes = [
		'sayhello/test'
	];

	public function __construct()
	{
		$this->theme_url  = get_template_directory_uri();
		$this->theme_path = get_template_directory();
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = false;
		}
		$this->min = false;
		if (file_exists($this->theme_path . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.css')) {
			$this->css = $this->theme_url . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.css';
		}
		if (file_exists($this->theme_path . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js')) {
			$this->js = $this->theme_url . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js';
		}
	}

	public function run()
	{
		if (! function_exists('register_block_type')) {
			return; // Gutenberg is not active.
		}
		add_action('enqueue_block_editor_assets', [ $this, 'enqueueBlockAssets' ]);
		add_action('wp_enqueue_scripts', [ $this, 'enqueueBlockFrontendAssets' ]);
		add_filter('block_categories', [ $this, 'blockCategories' ], 10, 1);
		add_filter('sht_disabled_blocks', [ $this, 'disabledBlockTypes' ]);
		add_action('after_setup_theme', [ $this, 'themeSupports' ]);
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

	}

	public function enqueueBlockAssets()
	{
		if ($this->js) {
			wp_enqueue_script(sht_theme()->prefix . '-gutenberg-script', $this->js, [ 'wp-blocks', 'wp-element', 'wp-edit-post', 'lodash' ], sht_theme()->version);
			$vars = json_encode(apply_filters('sht_disabled_blocks', []));
			wp_add_inline_script(sht_theme()->prefix . '-gutenberg-script', "var shtDisabledBlocks = {$vars};", 'before');
		}
		if ($this->css) {
			wp_enqueue_style(sht_theme()->prefix . '-gutenberg-styles', $this->css, [ 'wp-edit-blocks' ], sht_theme()->version);
		}
	}

	public function enqueueBlockFrontendAssets()
	{
		if ($this->css) {
			wp_enqueue_style(sht_theme()->prefix . '-gutenberg-styles', $this->css, [], sht_theme()->version);
		}
	}

	public function blockCategories($categories)
	{
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'sht/blocks',
					'title' => __('Blocks by Say Hello', 'sha'),
				],
			]
		);
	}

	public function disabledBlockTypes($blockTypes)
	{
		$toDisable = [
			'core/quote',
			'core/embed',
			'core/audio',
			'core/cover',
			'core/file',
			'core/video',
			// Formatting
			'core/preformatted',
			'core/freeform',
			'core/verse',
			// Layout
			'core/pullquote',
			'core/button',
			'core/columns',
			'core/media-text',
			'core/more',
			'core/nextpage',
			'core/separator',
			'core/spacer',
			// Widgets
			'core/archives',
			'core/categories',
			'core/latest-comments',
			'core/latest-posts',
			// Embeds
			'core-embed/twitter',
			'core-embed/youtube',
			'core-embed/facebook',
			'core-embed/instagram',
			'core-embed/wordpress',
			'core-embed/soundcloud',
			'core-embed/spotify',
			'core-embed/flickr',
			'core-embed/vimeo',
			'core-embed/animoto',
			'core-embed/cloudup',
			'core-embed/collegehumor',
			'core-embed/dailymotion',
			'core-embed/funnyordie',
			'core-embed/hulu',
			'core-embed/imgur',
			'core-embed/issuu',
			'core-embed/kickstarter',
			'core-embed/meetup-com',
			'core-embed/mixcloud',
			'core-embed/photobucket',
			'core-embed/polldaddy',
			'core-embed/reddit',
			'core-embed/reverbnation',
			'core-embed/screencast',
			'core-embed/scribd',
			'core-embed/slideshare',
			'core-embed/smugmug',
			'core-embed/speaker',
			'core-embed/ted',
			'core-embed/tumblr',
			'core-embed/videopress',
			'core-embed/wordpress-tv',
			'core-embed/crowdsignal',
			'core-embed/speaker-deck',
		];

		return is_array($blockTypes) ? array_merge($blockTypes, $toDisable) : $toDisable;
	}
}
