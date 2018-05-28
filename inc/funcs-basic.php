<?php

/**
 * this function returns an error message. If the Plugin "Hello-Log" is active it saves the error and returns only the error code.
 *
 * @since    0.0.1
 *
 * @param  string $error detailed error description
 * @param  string $shown_text the error the not-logged-in user sees
 *
 * @return [type]             [description]
 */
function sht_error( $error = '', $shown_text = '' ) {

	if ( current_user_can( 'administrator' ) || current_user_can( 'dev' ) ) {
		$return_text = $error;
	} elseif ( '' == $shown_text ) {
		$return_text = hello_theme()->error;
	} else {
		$return_text = $shown_text;
	}

	if ( '' == $return_text ) {
		$return_text = hello_theme()->error;
	}

	if ( function_exists( 'hellolog_register_log' ) ) {
		$code = hellolog_register_log( 'error', $error, debug_backtrace() );

		return $return_text . ' (' . __( 'ErrorCode', 'sht' ) . ': ' . $code . ')';
	} else {
		return $return_text;
	}
}

/**
 * returns an image
 *
 * @since    0.0.1
 *
 * @param  int $image_id post_ID of an attachment
 * @param  string $size desired attachment size (org_large)
 * @param  array $attributes html attributes
 * @param  boolean $background if true, a div containing a background image will be reurned instead of the <img>
 *
 * @return string                image or background-image ready to be loaded via lazysizes
 */
function sht_get_lazysizes_img( $image_id, $size, $attributes = [], $background = false ) {

	if ( get_post_type( $image_id ) != 'attachment' ) {
		return '';
	}

	if ( sht_theme()->Lazysizes->init ) {

		return sht_theme()->Lazysizes->get_lazysizes_img( $image_id, $size, $attributes, $background );

	} else {

		if ( $background ) {

			$atts = '';
			foreach ( $attributes as $key => $val ) {
				$atts .= $key . '="' . esc_attr( $val ) . '" ';
			}

			return '<div ' . $atts . ' style="background-image: url(' . wp_get_attachment_image_src( $image_id, $size )[0] . ')"; ></div>';

		} else {
			return wp_get_attachment_image( $image_id, $size, false, $attributes );
		}
	}
}

/**
 * this function can be used to exit an admin-ajax function and encodes the answer to json_decode
 *
 * @since    0.0.1
 *
 * @param  string $type status type (success, error, warning, ..)
 * @param  string $msg returned text
 * @param  array $add additional information as an array
 *
 * @return exit|echo  echoes a json and dies
 */
function sht_exit_ajax( $type, $msg, $add = [] ) {

	$return = [
		'type'    => $type,
		'message' => $msg,
		'add'     => $add,
	];

	echo json_encode( $return );

	wp_die();
}

/**
 * This function returns the settings value from assets/settings.js
 *
 * @since    0.1.0
 *
 * @param string $setting settings key
 *
 * @return bool | string
 */
function sht_get_setting( $setting ) {
	$path = trailingslashit( get_template_directory() ) . 'assets/settings.json';
	if ( ! is_file( $path ) ) {
		return false;
	}

	$settings = json_decode( file_get_contents( $path ), true );
	if ( ! array_key_exists( $setting, $settings ) ) {
		return false;
	}

	return $settings[ $setting ];
}

/**
 * this function returns a i-Tag with an SVG-Icon inside
 *
 * @since    0.0.1
 *
 * @param  string $icon icon filename or path
 * @param  array $classes array of classes that will be added
 *
 * @return string          <i ...><svg ...></svg></i>
 */
function get_helloicon( $icon, $classes = [] ) {

	$path_min = get_template_directory() . "/assets/img/icons/$icon.min.svg";
	$path     = get_template_directory() . "/assets/img/icons/$icon.svg";

	$c = array_merge( [ 'hello-icon' ], $classes );

	if ( file_exists( $path_min ) ) {
		return '<i class="' . implode( ' ', $c ) . '">' . file_get_contents( $path_min ) . '</i>';
	} elseif ( file_exists( $path ) ) {
		return '<i class="' . implode( ' ', $c ) . '">' . file_get_contents( $path ) . '</i>';
	} else {
		return 'icon not found ' . $path_min . ' / ' . $path;
	}
}

/**
 * this function echoes what get_helloicon() returns
 *
 * @since    0.0.1
 *
 * @param  string $icon icon filename or path
 * @param  array $classes array of classes that will be added
 **/
function helloicon( $icon, $classes = [] ) {
	echo get_helloicon( $icon, $classes );
}

/**
 * this function returns the $html where all iframes are lazyloaded optimazed
 *
 * @since    0.0.1
 *
 * @param  string $html
 *
 * @return string
 */
function sht_lazyframes( $html ) {
	return hello_theme()->LazySizes->render_lazyframes( $html );
}

/**
 * @since    0.0.1
 *
 * @param string /array $classes
 */
function sht_sayhello_autoload() {

	$folder = trailingslashit( get_template_directory() ) . 'classes/autoload/';
	$files  = preg_grep( '~^class-.*\.(php)$~', scandir( $folder ) );

	foreach ( $files as $file ) {
		$class      = ucfirst( str_replace( [ 'class-', '.php' ], '', $file ) );
		$path       = $folder . $file;
		$class_name = 'SayHello\autoload\\' . $class;
		if ( ! class_exists( $class ) && is_file( $path ) ) {
			require_once $path;
			sht_theme()->$class = new $class_name();
		}
	}
}

/**
 * This function check if a given attachment ID is a svg or not
 *
 * @since    0.1.0
 *
 * @param $attachment_id
 *
 * @return bool
 */
function sht_is_svg( $attachment_id ) {
	if ( 'attachment' != get_post_type( $attachment_id ) ) {
		return false;
	}

	return 'image/svg+xml' === get_post_mime_type( $attachment_id );
}

/**
 * @since    0.1.0
 *
 * @return string returns the custom logo similar to the core function get_custom_logo()
 */
function sht_get_logo() {

	$custom_logo_id   = get_theme_mod( 'custom_logo' );
	$custom_logo_attr = [
		'class'    => 'header__logo-img',
		'itemprop' => 'logo',
	];

	if ( $custom_logo_id ) {

		$html = sprintf( '<a href="%1$s" class="logo header__logo" rel="home" itemprop="url">', esc_url( home_url( '/' ) ) );
		if ( sht_is_svg( $custom_logo_id ) ) {

			$atts = '';
			foreach ( $custom_logo_attr as $name => $value ) {
				$atts .= " $name=" . '"' . $value . '"';
			}

			$html .= str_replace( '<svg', "<svg $atts", file_get_contents( get_attached_file( $custom_logo_id ) ) );
		} elseif ( $custom_logo_id ) {
			$html .= wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
		}
		$html .= '</a>';

		return $html;
	}

	return sprintf( '<a href="%1$s" class="logo header__logo" style="display:none;"><img class="custom-logo"/></a>', esc_url( home_url( '/' ) ) );
}

/**
 * @since    0.1.0
 *
 * @return string prints the custom logo similar to the core function get_custom_logo()
 */
function sht_logo() {
	echo sht_get_logo();
}
