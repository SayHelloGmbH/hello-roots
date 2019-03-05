<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with images, videos etc
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Media
{
	/**
	 * This function check if a given attachment ID is a svg or not
	 *
	 * @since    0.1.0
	 *
	 * @param $attachment_id
	 *
	 * @return bool
	 */
	public function isSVG($attachment_id)
	{
		if ('attachment' !== get_post_type($attachment_id)) {
			return false;
		}

		return 'image/svg+xml' === get_post_mime_type($attachment_id);
	}
}
