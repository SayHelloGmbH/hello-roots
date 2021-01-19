<?php

namespace SayHello\Theme\PostType;

use WP_Post;

/**
 * Stuff for the Block Areas custom post type
 * The functionality is provided by the third-party Plugin https://wordpress.org/plugins/block-areas/
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class BlockAreas
{

	public function run()
	{
		add_filter('register_post_type_args', [$this, 'customPostTypeArgs']);
	}

	public function customPostTypeArgs($args)
	{
		if (isset($args['capability_type']) && $args['capability_type'] === 'block') {
			$args['public'] = true;
		}
		return $args;
	}
}
