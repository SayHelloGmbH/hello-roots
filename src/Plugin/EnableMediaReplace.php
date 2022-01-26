<?php

namespace SayHello\Theme\Plugin;

/**
 * EnableMediaReplace stuff
 * Can be deleted if the "Enable Media Replace" plugin is not in use
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class EnableMediaReplace
{

	public function run()
	{
		add_action('after_setup_theme', [$this, 'disableEMRNews']);
	}


	public function disableEMRNews()
	{
		update_option('emr_news', true);
	}
}
