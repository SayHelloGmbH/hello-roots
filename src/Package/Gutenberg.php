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
		add_action('enqueue_block_editor_assets', [$this, 'enqueueBlockAssets']);
		add_filter('block_categories', [$this, 'blockCategories']);
		add_filter('block_editor_settings', [ $this, 'editorSettings' ]);
		//add_filter('sht_disabled_blocks', [$this, 'disableCoreBlockTypes']);
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
		add_theme_support('disable-custom-colors');
		add_theme_support('editor-color-palette', []);
		add_theme_support('disable-custom-font-sizes');
		add_theme_support('editor-font-sizes', []);
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
	 * Last updated 7.10.2019 with WordPress 5.2.3 and Gutenberg Plugin 6.6.0
	 *
	 * To get the current list of blocks in the version of Gutenberg you're running, call
	 * wp.blocks.getBlockTypes().forEach(function (data) {console.log(data.name);});
	 * in the browser JS console when the editor is open.
	 *
	 * @param  array $blockTypes The pre-defined array of allowed block types
	 * @return array             The potentially modified array of allowed block types
	 * @todo: Filter by current post type: e.g. Cover allowed on page but not Post. mhm 13.5.2019
	 */
	public function disableCoreBlockTypes(array $allowed_types)
	{
		$coreBlocks = [
			'core/archives',
			'core/audio',
			'core/block',
			'core/button',
			'core/calendar',
			'core/categories',
			'core/code',
			'core/column',
			'core/columns',
			'core/cover',
			'core/embed',
			'core/file',
			'core/freeform',
			'core/gallery',
			'core/group',
			'core/heading',
			'core/html',
			'core/image',
			'core/latest-comments',
			'core/latest-posts',
			'core/list',
			'core/media-text',
			'core/missing',
			'core/more',
			'core/nextpage',
			'core/paragraph',
			'core/preformatted',
			'core/pullquote',
			'core/quote',
			'core/rss',
			'core/search',
			'core/separator',
			'core/shortcode',
			'core/social-link-amazon',
			'core/social-link-bandcamp',
			'core/social-link-behance',
			'core/social-link-chain',
			'core/social-link-codepen',
			'core/social-link-deviantart',
			'core/social-link-dribbble',
			'core/social-link-dropbox',
			'core/social-link-etsy',
			'core/social-link-facebook',
			'core/social-link-feed',
			'core/social-link-fivehundredpx',
			'core/social-link-flickr',
			'core/social-link-foursquare',
			'core/social-link-github',
			'core/social-link-goodreads',
			'core/social-link-google',
			'core/social-link-instagram',
			'core/social-link-lastfm',
			'core/social-link-linkedin',
			'core/social-link-mail',
			'core/social-link-mastodon',
			'core/social-link-medium',
			'core/social-link-meetup',
			'core/social-link-pinterest',
			'core/social-link-pocket',
			'core/social-link-reddit',
			'core/social-link-skype',
			'core/social-link-snapchat',
			'core/social-link-soundcloud',
			'core/social-link-spotify',
			'core/social-link-tumblr',
			'core/social-link-twitch',
			'core/social-link-twitter',
			'core/social-link-vimeo',
			'core/social-link-vk',
			'core/social-link-wordpress',
			'core/social-link-yelp',
			'core/social-link-youtube',
			'core/social-links',
			'core/spacer',
			'core/subhead',
			'core/table',
			'core/tag-cloud',
			'core/text-columns',
			'core/verse',
			'core/video',
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
			'core-embed/youtube'
		];

		$disallowed_types = [];
		foreach ($coreBlocks as $block) {
			if (!in_array($block, $this->allowedCoreBlocks)) {
				$disallowed_types[] = $block;
			}
		}

		return array_merge($allowed_types, $disallowed_types);
	}

	public function isContextEdit()
	{
		return array_key_exists('context', $_GET) && $_GET['context'] === 'edit';
	}
}
