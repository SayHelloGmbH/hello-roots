<?php

namespace SayHello\Theme\Package;

/**
 * Multilingual stuff and translations
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Language
{

	public function run()
	{
		add_action('after_setup_theme', [$this, 'loadTranslations']);
	}

	/**
	 * Load the translation files which are delivered with the Theme
	 * Other files - stored in wp-content/languages - are loaded automatically.
	 *
	 * @return void
	 */
	public function loadTranslations()
	{
		load_theme_textdomain('sht', get_template_directory() . '/languages'); // Textdomain Frontend
		load_theme_textdomain('sha', get_template_directory() . '/languages'); // Textdomain Admin
	}
}
