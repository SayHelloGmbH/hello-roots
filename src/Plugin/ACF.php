<?php

namespace SayHello\Theme\Plugin;

/**
 * ACF stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class ACF
{

	/**
	 * Statuses which should be selectable in an ACF field
	 * @var array
	 */
	public static $allowedStatuses = [
		'publish'
	];

	public function run()
	{
		add_filter('acf/fields/post_object/query', [$this, 'restrictStatus']);
		add_filter('acf/fields/relationship/query', [$this, 'restrictStatus']);
		add_action('acf/input/admin_footer', [$this, 'colorPickerPalette']);
	}

	/**
	 * The function acf_register_block_type passes four arguments to
	 * render_callback (or render_template). The third one is $is_preview.
	 * This argument is boolean true if the block is being viewed in the
	 * editor, but an object of type WP_Block if it's being viewed in the
	 * frontend. This function makes sure that it's a boolean AND true.
	 *
	 * @param  boolean $is_preview The value passed into render_callback or render_template
	 * @return boolean
	 */
	public function isContextEdit($is_preview)
	{
		return $is_preview === true;
	}

	/**
	 * Customize ACF color picker to match Gutenberg palette
	 * @return [type] [description]
	 */
	public function colorPickerPalette()
	{

		$settings = sht_theme()->getSettings();

		if (empty($settings['acf_colors'])) {
			return;
		}

		$colors = [];

		foreach ($settings['acf_colors'] as $color_key => $color) {
			$colors[] = '"' . $color . '"';
		}

		if (empty($colors)) {
			return;
		}

		printf(
			'<script type="text/javascript">(function($) {
				acf.add_filter("color_picker_args", function( args, $field ){
					args.palettes = [%s];
					return args;
				});
			})(jQuery);</script>',
			implode(',', $colors)
		);
	}

	/**
	 * Retrict statuses which are allowed to be selected in the ACF field
	 * @param  array $options Field options
	 * @return array           The modified options
	 */
	public function restrictStatus($options)
	{
		$options['post_status'] = self::$allowedStatuses;
		return $options;
	}
}
