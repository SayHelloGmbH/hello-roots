<?php

namespace SayHello\Theme\Package;

/**
 * Adjustments for the Gutenberg Editor
 *
 * @author Nico Martin <nico@sayhello.ch>
 */
class Gutenberg
{
	public function run()
	{
		add_filter('allowed_block_types', [ $this, 'supportedBlockTypes' ], 1);
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
