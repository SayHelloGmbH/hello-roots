<?php

namespace SayHello\Theme\Package;

use SayHello\Theme\Vendor\LazyImage;

/**
 * Helper functions
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Helpers
{
	/**
	 * Convert a telephone number in the common Swiss number formats to a valid tel: link
	 *
	 * @param  string $number The legible phone number
	 *
	 * @return string         The usable tel: link
	 */
	public static function telephoneUrl($number)
	{
		$nationalprefix  = '+41';
		$protocol        = 'tel:';
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
