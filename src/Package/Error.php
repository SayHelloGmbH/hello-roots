<?php

namespace SayHello\Theme\Package;

/**
 * Error handling
 *
 * @author Nico Martin <nico@sayhello.ch>
 */
class Error
{

	public function run()
	{
		// Third party plugin support
		add_filter('hellolog_types', [ $this, 'registerErrorLog' ], 10, 1);
	}

	public function registerErrorLog($types)
	{
		$types[ 'error' ] = __('Error', 'sha');

		return $types;
	}

	/**
	 * this function returns an error message. If the Plugin "Hello-Log" is active it saves the error and returns only the error code.
	 * Usage: sht_theme()->Package->Error->get();
	 * Usage: sht_theme()->Package->Error->get('Error text for developer');
	 * Usage: sht_theme()->Package->Error->get('Error text for developer', 'Error text for user');
	 *
	 * @param string $error detailed error description
	 * @param string $shown_text the error the not-logged-in user sees
	 *
	 * @return string             The error message
	 */
	public function get($error = '', $shown_text = '')
	{

		if (current_user_can('administrator') || current_user_can('dev')) {
			$return_text = $error;
		} elseif ('' == $shown_text) {
			$return_text = sht_theme()->error;
		} else {
			$return_text = $shown_text;
		}

		if ('' == $return_text) {
			$return_text = sht_theme()->error;
		}

		if (function_exists('hellolog_register_log')) {
			$code = hellolog_register_log('error', $error, debug_backtrace());

			return $return_text . ' (' . __('ErrorCode', 'sht') . ': ' . $code . ')';
		} else {
			return $return_text;
		}
	}
}
