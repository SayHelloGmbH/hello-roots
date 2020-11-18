<?php

namespace SayHello\Theme\Package;

/**
 * Theme Options
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */

class ThemeOptions
{

	public $main_slug = '';
	public $general_slug = '';

	public function __construct()
	{
		$this->main_slug    = sht_theme()->prefix . '-settings';
	}

	public function run()
	{
		add_action('acf/init', [ $this, 'page' ], 1);
		add_action('acf/init', [ $this, 'options' ]);
		add_action('acf/init', [ $this, 'acfInit' ]);
		add_action('after_setup_theme', [$this, 'disableEMRNews']);
	}

	public function disableEMRNews()
	{
		update_option('emr_news', true);
	}

	public function acfInit()
	{
		$prefix = sht_theme()->prefix;
		acf_update_setting('google_api_key', get_field("{$prefix}-maps-api-key", 'options'));
	}

	public function page()
	{
		if (function_exists('acf_add_options_sub_page')) {
			acf_add_options_sub_page(
				[
					'page_title'  => __('Theme-Optionen', 'sha'),
					'menu_title'  => __('Theme-Optionen', 'sha'),
					'menu_slug'   => $this->main_slug,
					'parent_slug' => 'themes.php',
					'capability'  => 'edit_theme_options',
				]
			);
		}
	}

	public function options()
	{

		/**
		 * Contact
		 */

		if (function_exists('acf_add_local_field_group')) {
			$prefix = sht_theme()->prefix;

			acf_add_local_field_group([
				'key' => "{$prefix}-options-group",
				'title' => 'Theme Options',
				'fields' => [
					[
						'key' => "{$prefix}-maps-api-key",
						'label' => 'Google Maps API Key',
						'key' => "{$prefix}-maps-api-key",
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					],
				],
				'location'   => [
					[
						[
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => $this->main_slug,
						],
					],
				],
				'menu_order' => 10,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			]);

			// We can't use is_plugin_active() here because
			// that function hasn't been defined when this
			// code is being called.
			if (in_array('block-areas/block-areas.php', apply_filters('active_plugins', get_option('active_plugins')))) {
				acf_add_local_field_group([
					'key' => "{$prefix}-blockarea-group",
					'title' => 'Inhaltsbereiche',
					'fields' => [
						[
							'key' => "{$prefix}-blockarea-footer",
							'label' => 'Footer Block Area',
							'name' => "{$prefix}-blockarea-footer",
							'type' => 'post_object',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => [
								'width' => '',
								'class' => '',
								'id' => '',
							],
							'post_type' => [
								0 => 'block_area',
							],
							'taxonomy' => '',
							'allow_null' => 0,
							'multiple' => 0,
							'return_format' => 'object',
							'ui' => 1,
						],
					],
					'location'   => [
						[
							[
								'param'    => 'options_page',
								'operator' => '==',
								'value'    => $this->main_slug,
							],
						],
					],
					'menu_order' => 5,
					'position' => 'normal',
					'style' => 'default',
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' => '',
					'active' => true,
					'description' => '',
				]);
			}
		}
	}
}
