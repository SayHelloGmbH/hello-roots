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

	public function __construct()
	{
		$this->theme_url  = get_template_directory_uri();
		$this->theme_path = get_template_directory();
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = false;
		}
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
		add_action('init', [ $this, 'initBlockTypes' ]);
		add_action('enqueue_block_editor_assets', [ $this, 'enqueueBlockAssets' ]);
		add_action('wp_enqueue_scripts', [ $this, 'enqueueBlockFrontendAssets' ]);
		add_filter('allowed_block_types', [ $this, 'supportedBlockTypes' ], 1);
	}

	public function initBlockTypes()
	{
		register_block_type('sayhellogmbh/teaser');
	}

	public function enqueueBlockAssets()
	{
		if ($this->js) {
			wp_enqueue_script(sht_theme()->prefix . '-gutenberg-script', $this->js, [ 'wp-blocks', 'wp-element', 'wp-edit-post', 'lodash' ], sht_theme()->version);
		}
		if ($this->css) {
			wp_enqueue_style(sht_theme()->prefix . '-gutenberg-styles', $this->css, [ 'wp-edit-blocks' ], sht_theme()->version);
		}
	}

	public function enqueueBlockFrontendAssets()
	{
		if ($this->css) {
			wp_enqueue_style(sht_theme()->prefix . '-gutenberg-styles', $this->css, [ 'wp-edit-blocks' ], sht_theme()->version);
		}
	}

	public function supportedBlockTypes($blockTypes)
	{
		return [
			'core/paragraph',
			'core/image',
			'core/heading',
			'core/gallery',
			'core/list',
			'core/shortcode',
			'core/code',
			'core/table',
		];
	}
}
