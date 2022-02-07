<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with images, videos etc
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Media
{

	public function run()
	{
		add_action('after_setup_theme', [$this, 'addImageSizes']);
		add_filter('image_size_names_choose', [$this, 'selectableImageSizes']);
		add_filter('post_thumbnail_size', [$this, 'fixPostThumbnailSize']);
	}

	public function addImageSizes()
	{
		add_image_size('gutenberg_wide', 1200, 9999);
		add_image_size('gutenberg_full', 2560, 9999);
	}

	public function selectableImageSizes($sizes)
	{
		$sizes['gutenberg_wide'] = _x('Gutenberg breit', 'Custom selectable image size', 'sht');
		$sizes['gutenberg_full'] = _x('Gutenberg volle Breite', 'Custom selectable image size', 'sht');
		return $sizes;
	}

	/**
	 * The default value of get_the_post_thumbnail is "post-thumbnail"
	 * which leads to the incorrectly-sized image being returned by core.
	 * This is a temporary solution, until the core issue is fixed.
	 *
	 * See https://github.com/WordPress/gutenberg/issues/33789#issuecomment-966076784
	 * See https://core.trac.wordpress.org/ticket/17262
	 *
	 * @param string $size
	 * @return string
	 */
	public function fixPostThumbnailSize($size)
	{
		if ($size === 'post-thumbnail') {
			return 'thumbnail';
		}
		return $size;
	}
}
