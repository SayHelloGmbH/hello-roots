<?php

namespace SayHello\Theme\PostType;

use WP_Post;

/**
 * Stuff for the Block Areas custom post type
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
		$args['public'] = true;
		return $args;
	}
}
