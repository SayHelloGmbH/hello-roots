<?php

namespace SayHello\Theme\Package;

/**
 * ACF stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class ACF
{

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
}
