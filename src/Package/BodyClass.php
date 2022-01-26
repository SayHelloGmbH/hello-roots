<?php

namespace SayHello\Theme\Package;

/**
 * CSS class for BODY tag
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */

class Bodyclass
{

	public function run()
	{
		add_filter('body_class', [$this, 'bodyClasses'], 10, 1);
	}

	/**
	 * Provides a function that adds custom
	 * css Classes to Website
	 *
	 * @param array $classes Default body classes
	 *
	 * @return array Containing all necessary Classes
	 */
	public function bodyClasses(array $classes)
	{
		$classes[] = 'no-js';

		if (sht_theme()->debug) {
			$classes[] = 'c-body--themedev';
		}

		return $classes;
	}
}
