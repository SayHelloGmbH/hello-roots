<?php

namespace SayHello\Theme\Plugin;

/**
 * Yoast stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Yoast
{

	public function run()
	{
		add_filter('wpseo_metabox_prio', [$this, 'lowerYoastMetaboxPriority']);
	}

	/**
	 * Lowers the YOAST Metabox priority, so that it wont be on the upper part of the editor by default.
	 *
	 * @return string Priority of the YOAST Metabox
	 */
	public function lowerYoastMetaboxPriority()
	{
		return 'low';
	}
}
