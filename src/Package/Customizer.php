<?php

namespace SayHello\Theme\Package;

/**
 * 10.11.2021:
 * The Customizer may be phased out with FSE. Code in this
 * file is intended as a temporary bridge to ensure
 * continued support for now.
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Customizer
{
	public function run()
	{
		add_action('admin_menu', [$this, 'customizerLink']);
	}

	public function customizerLink()
	{
		// Exit early if the FSE theme feature isn't present or the current theme is not a FSE theme.
		if (!function_exists('gutenberg_is_fse_theme') || function_exists('gutenberg_is_fse_theme') && !gutenberg_is_fse_theme()) {
			return;
		}

		add_submenu_page(
			'themes.php',
			__('Customizer'),
			__('Customizer'),
			'manage_options',
			'customize.php'
		);
	}
}
