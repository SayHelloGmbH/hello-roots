<?php

namespace SayHello\Theme\Plugin;

/**
 * GravityForms stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class GravityForms
{

	public function run()
	{
		add_filter('gform_ajax_spinner_url', [$this, 'replaceGravityFormsSpinner']);
	}

	/**
	 * Replace ajax spinner. Don't forget to
	 * add the CSS for the replaced image.
	 *
	 * @return void
	 */
	public function replaceGravityFormsSpinner()
	{
		return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	}
}
