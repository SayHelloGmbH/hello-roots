<?php

namespace SayHello\Theme\Package;

class Bodyclass
{

	public function run()
	{
		add_filter('body_class', [ $this, 'bodyClasses' ], 10, 1);
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
		if (sht_theme()->debug) {
			$classes[] = 'theme-dev';
		}
		return $classes;
	}
}
