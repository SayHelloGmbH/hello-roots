<?php

namespace SayHello\Theme\Package;

use SayHello\Theme\Vendor\LazyImage;

/**
 * Helper functions
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Helpers {

	public static function dump($var, $exit = false) {
		echo '<pre>' . print_r($var, true) . '</pre>';
		if ($exit) {
			exit;
		}
	}

	/**
	 * returns an image
	 *
	 * @since    0.0.1
	 *
	 * @param  int|WP_Post $image post_object or post_id of an attachment
	 * @param  string|array $size Image size. Accepts any valid image size, or an array of width and height values in pixels (in that order).
	 * @param  string $class classes
	 * @param  boolean $background if true, a div containing a background image will be reurned instead of the <img>
	 * @param  array $attributes an array of additional attributes for the image
	 *
	 * @return string                image or background-image ready to be loaded via lazysizes
	 */
	public static function getLazyImage($image, $size, $class = '', $background = false, $attributes = []) {

		$image_object = new LazyImage($image, $size);
		$image_object->set_wrapper_class($class);
		$image_object->set_attributes($attributes);

		return $image_object->get_image($background);
	}
	
		/**
	 * Convert a telephone number in the common Swiss number formats to a valid tel: link
	 * @param  string $number The legible phone number
	 * @return string         The usable tel: link
	 */
	public static function telephoneUrl($number)
	{
		$nationalprefix = '+41';
		$protocol = 'tel:';
		$formattedNumber = $number;
		if ($formattedNumber !== '') {
			// add national dialing code prefix to tel: link if it's not already set
			if (strpos($formattedNumber, '00') !== 0 && strpos($formattedNumber, '0800') !== 0 && strpos($formattedNumber, '+') !== 0 && strpos($formattedNumber, $nationalprefix) !== 0) {
				$formattedNumber = preg_replace('/^0/', $nationalprefix, $formattedNumber);
			}
		}
		$formattedNumber = str_replace('(0)', '', $formattedNumber);
		$formattedNumber = preg_replace('~[^0-9\+]~', '', $formattedNumber);
		$formattedNumber = trim($formattedNumber);
		return $protocol . $formattedNumber;
	}

}
