<?php

/**
 * @return string returns the custom logo similar to the core function get_custom_logo()
 */
if (!function_exists('sht_get_logo')) {
	function sht_get_logo() {

		$custom_logo_id = get_theme_mod('custom_logo');
		$custom_logo_attr = [
			'class' => 'header__logo-img',
			'itemprop' => 'logo',
		];

		if ($custom_logo_id) {

			$html = sprintf('<a href="%1$s" class="logo header__logo" rel="home" itemprop="url">', esc_url(home_url('/')));
			if (sht_is_svg($custom_logo_id)) {

				$atts = '';
				foreach ($custom_logo_attr as $name => $value) {
					$atts .= " $name=" . '"' . $value . '"';
				}

				$html .= str_replace('<svg', "<svg $atts", file_get_contents(get_attached_file($custom_logo_id)));
			} elseif ($custom_logo_id) {
				$html .= wp_get_attachment_image($custom_logo_id, 'full', false, $custom_logo_attr);
			}
			$html .= '</a>';

			return $html;
		}

		return sprintf('<a href="%1$s" class="logo header__logo" style="display:none;"><img class="custom-logo"/></a>', esc_url(home_url('/')));
	}
}

/**
 * @return string prints the custom logo similar to the core function get_custom_logo()
 */
if (!function_exists('sht_logo')) {
	function sht_logo() {
		echo sht_get_logo();
	}
}