<?php

namespace SayHello\Theme\PostType;

/**
 * Stuff for Pages
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Page
{

	const POST_TYPE = 'page';
	const PREFIX = 'sht_page';

	public function run()
	{
		add_action('init', [$this, 'registerMetaFields']);
	}

	public function registerMetaFields()
	{
		register_post_meta(self::POST_TYPE, 'hide_title', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'boolean',
			'auth_callback' => function () {
				return current_user_can('edit_pages');
			}
		]);
	}
}
