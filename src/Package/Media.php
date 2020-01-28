<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with images, videos etc
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Media
{

	public function run()
	{
		add_action('after_setup_theme', [ $this, 'addImageSizes' ]);
		add_filter('image_size_names_choose', [$this, 'selectableImageSizes']);
	}

	public function addImageSizes()
	{
		add_image_size('gutenberg_wide', 1280, 9999);
		add_image_size('gutenberg_full', 2560, 9999);
	}

	public function selectableImageSizes($sizes)
	{
		$sizes['gutenberg_wide'] = _x('Gutenberg breit', 'Custom selectable image size', 'sht');
		$sizes['gutenberg_full'] = _x('Gutenberg voll', 'Custom selectable image size', 'sht');
		return $sizes;
	}
}
