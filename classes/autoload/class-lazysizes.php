<?php

namespace SayHello\autoload;

/**
 * This Class provides advanced media loading possibilities via lazysizes.
 * Please make sure you included https://github.com/aFarkas/lazysizes/ so the images are loaded via JS.
 * <noscript> Fallback is provided as well
 *
 * @author Nico Martin <nico@sayhello.ch>
 */

class Lazysizes {

	public $init = false;
	public $default_sizes = '';

	public function __construct() {
		$this->init          = true;
		$this->default_sizes = [
			'prev'   => 10,
			'window' => 2000,
			'page'   => 1200,
			'large'  => 640,
			'medium' => 320,
			'small'  => 160,
		];
	}

	public function run() {
		add_action( 'wp_head', [ $this, 'noscript_css' ], 50 );
		add_filter( 'the_content', [ $this, 'render_lazyframes' ], 200 );
	}

	public function noscript_css() {
		?>
		<noscript>
			<style type="text/css">
				div.lazyload, img.lazyload {
					display: none !important;
				}
			</style>
		</noscript>
		<?php
	}

	/**
	 * @param int $image_id wp media element ID
	 * @param string $size image size (format_size), ex. "org_large" or "1x2_small"
	 * @param array $attributes
	 * @param bool $background if server as background image
	 *
	 * @return string image html markup for an image using lazysizes
	 */
	public function get_lazysizes_img( $image_id, $size, $attributes = [], $background = false ) {

		$check_data = $this->_check_image_data( $image_id, $size );
		if ( '' != $check_data ) {
			return $check_data;
		}

		$transparent_mode = apply_filters( 'lazy_sizes_transparent', false );
		$background_color = apply_filters( 'lazy_sizes_background_color', 'transparent' );

		// Image Settings
		$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

		// return directly if is SVG
		if ( 'image/svg+xml' == get_post_mime_type( $image_id ) ) {
			if ( $background ) {
				$class = ( isset( $attributes['class'] ) ? $attributes['class'] . ' lazysizes-background' : 'lazysizes-background' );
				$src   = wp_get_attachment_image_src( $image_id, 'full' )[0];

				return '<div class="' . $class . '" style="background-image: url(' . $src . ');"></div>';

			} else {
				return wp_get_attachment_image( $image_id, 'full', false, $attributes );
			}
		}

		// Get Image Set
		$imageset = $this->_get_lazysizes_imageset( $image_id, $size );
		$srcset   = [];
		foreach ( $imageset as $setsize => $seturl ) {
			$srcset[] = $seturl . ' ' . $setsize . 'w';
		}
		$srcset = implode( ', ', $srcset );

		// Get Imagepre
		$imagepre = $this->_get_imagepre( $image_id, $size );

		// Attributes
		$org_image        = $this->_get_image_from_lskey( $image_id, $size );
		$org_image_src    = $org_image[0];
		$org_image_width  = $org_image[1];
		$org_image_height = $org_image[2];
		$atts             = shortcode_atts( [
			'class'      => '',
			'width'      => $org_image_width,
			'height'     => $org_image_height,
			'alt'        => $image_alt,
			'data-sizes' => 'auto',
		], $attributes );

		$atts_noscript = $atts;

		$atts          = apply_filters( 'lazy_sizes_attributes', $atts );
		$atts['class'] .= ( '' == $atts['class'] ? 'lazyload' : ' lazyload' );

		/**
		 * Output
		 */

		$return = '';

		if ( $background ) {

			$atts['class'] .= ' lazysizes-background';

			$return .= '<div ' . $this->_parse_atts( $atts ) . ' style="background-image: url(' . $imagepre . '); background-color: ' . $background_color . ';" data-bgset="' . $srcset . '" ></div>';
			$return .= '<noscript><div ' . $this->_parse_atts( $atts_noscript ) . ' style="background-image: url(' . $org_image_src . ')"></div></noscript>';

		} else {

			$return .= '<div class="lazysizes-wrapper ' . ( $transparent_mode ? 'transparent-mode' : '' ) . '" style="background-color: ' . $background_color . '">';
			$return .= '<img ' . $this->_parse_atts( $atts ) . ' src="' . $imagepre . '" data-srcset="' . $srcset . '" role="img">';
			$return .= '<noscript><img ' . $this->_parse_atts( $atts_noscript ) . ' src="' . $org_image_src . '" srcset="' . $srcset . '" role="img"></noscript>';
			$return .= '</div>';

		}

		return $return;
	}

	/**
	 * Lazyframe
	 */

	public function render_lazyframes( $html ) {

		$re = '/<iframe(.*?)>(.*?)<\/iframe>/';
		preg_match_all( $re, $html, $iframes, PREG_SET_ORDER, 0 );

		foreach ( $iframes as $iframe ) {

			$height = 0;
			$width  = 0;

			$attributes_string = $iframe[1];
			$attributes_new    = $attributes_string;
			$element           = $iframe[0];

			$re = '/(\w+)="([^"]+)"/';
			preg_match_all( $re, $attributes_string, $attributes, PREG_SET_ORDER, 0 );
			foreach ( $attributes as $a ) {

				$attr = $a[1];
				$val  = $a[2];
				$full = $a[0];

				if ( 'src' == $attr ) {
					$attributes_new = str_replace( $full, 'data-src="' . $val . '"', $attributes_new );
				}

				if ( 'height' == $attr ) {
					$height         = $val;
					$attributes_new = str_replace( $full, 'height="auto"', $attributes_new );

				} elseif ( 'width' == $attr ) {
					$width          = $val;
					$attributes_new = str_replace( $full, 'width="auto"', $attributes_new );
				}
			}

			if ( ! strpos( $attributes_new, 'class="' ) ) {
				$attributes_new = $attributes_new . ' class="lazyload"';
			} else {
				$attributes_new = str_replace( 'class="', 'class="lazyload ', $attributes_new );
			}

			$element_new = str_replace( $attributes_string, $attributes_new, $element );

			if ( 0 != $width && 0 != $height ) {
				$padding     = $height / $width * 100;
				$element_new = '<div class="responsive-iframe" style="padding-bottom:' . $padding . '%">' . $element_new . '</div>';
			}

			$html = str_replace( $element, $element_new, $html );

		} // End foreach().

		return $html;
	}

	/**
	 * Helpers
	 */

	private function _check_image_data( $image_id, $size ) {

		if ( get_post_type( $image_id ) != 'attachment' ) {
			return 'Invalid Image ID';
		}

		if ( strpos( get_post_mime_type( $image_id ), 'image' ) !== 0 ) {
			return 'Invalid Image mime type';
		}

		if ( count( explode( '_', $size ) ) != 2 ) {
			return "Invalid size format '$size'";
		}

		$ratio = explode( '_', $size )[0];
		$size  = explode( '_', $size )[1];
		$sizes = $this->_get_sizes();

		if ( 'org' != $ratio && ! preg_match_all( '/^[0-9]+x[0-9]+$/', $ratio, $matches, PREG_SET_ORDER, 0 ) ) {
			return "Invalid Ratio: '$ratio'";
		}

		if ( ! isset( $sizes[ $size ] ) ) {
			$valid = implode( ', ', array_keys( $sizes ) );

			return "Invalid Size: '$size'. Possible sizes: $valid";
		}

		return '';
	}

	private function _parse_atts( $atts = [] ) {
		if ( ! is_array( $atts ) ) {
			return '';
		}

		$return = '';
		foreach ( $atts as $key => $val ) {
			$return .= $key . '="' . $val . '" ';
		}

		return $return;
	}

	private function _get_sizes() {

		$sizes = apply_filters( 'lazy_sizes_size', $this->default_sizes );

		foreach ( $sizes as $key => $size ) {
			$size = intval( $size );
			if ( 0 == $size ) {
				echo "LazySizes Size \"$key\" has to be an integer";
				die();
			}
			$sizes[ $key ] = $size;
		}
		arsort( $sizes );

		return $sizes;
	}

	/**
	 * lazysizes helpers
	 */

	private function _get_lazysizes_imageset( $image_id, $size ) {

		if ( '' != $this->_check_image_data( $image_id, $size ) ) {
			return false;
		}

		$sizes        = $this->_get_sizes();
		$image_format = explode( '_', $size )[0];
		$image_size   = explode( '_', $size )[1];
		$imageset     = [];

		foreach ( $sizes as $key => $width ) {

			if ( $width > $sizes[ $image_size ] ) {
				continue;
			}

			$new_image          = $this->_get_image_from_lskey( $image_id, "{$image_format}_$key" );
			$imageset[ $width ] = $new_image[0];
		}

		return $imageset;
	}

	private function _get_image_from_lskey( $image_id, $size ) {
		$image_format = explode( '_', $size )[0];
		$image_size   = explode( '_', $size )[1];
		$width        = $this->_get_sizes()[ $image_size ];
		$height       = 99999;
		$crop         = false;
		if ( 'org' != $image_format ) {
			$ratio  = explode( 'x', $image_format );
			$height = round( $width / $ratio[0] * $ratio[1] );
			$crop   = true;
		}

		return $this->_generate_image( $image_id, $width, $height, $crop );
	}

	private function _get_imagepre( $image_id, $size, $background = 'transparent' ) {

		$transparent_mode = apply_filters( 'lazy_sizes_transparent', false );

		$image        = $this->_get_image_from_lskey( $image_id, $size );
		$image_w      = $image[1];
		$image_h      = $image[2];
		$image_format = explode( '_', $size )[0];

		$sizes = $this->_get_sizes();

		if ( $transparent_mode ) {

			if ( 'org' == $image_format ) {
				$teiler = 10;
				if ( $image_w >= 1000 ) {
					$teiler = 100;
				}
				$ph_width  = round( $image_w / $teiler );
				$ph_height = round( $image_h / $teiler );
			} else {
				$ph_width  = explode( 'x', $image_format )[0];
				$ph_height = explode( 'x', $image_format )[1];
			}

			return $this->_generate_placeholder_image( $ph_width, $ph_height, $background );

		} else {
			$smallest_size = key( array_slice( $sizes, - 1, true ) );

			return $this->_get_image_from_lskey( $image_id, $image_format . '_' . $smallest_size )[0];
		}
	}

	private function _generate_placeholder_image( $width = 1, $height = 1, $color = 'transparent' ) {

		ob_start();
		$img = imagecreatetruecolor( $width, $height );
		if ( 'transparent' == $color ) {
			$black = imagecolorallocate( $img, 0, 0, 0 );
			imagecolortransparent( $img, $black );
		} else {
			list( $r, $g, $b ) = sscanf( $color, '#%02x%02x%02x' );
			$color = imagecolorallocate( $img, $r, $g, $b );
			imagefill( $img, 0, 0, $color );
		}
		imagegif( $img, null );

		$imagedata = ob_get_contents();

		ob_end_clean();

		return 'data:image/gif;base64,' . base64_encode( $imagedata );
	}

	private function _generate_image( $attach_id, $width, $height, $crop = false ) {

		/**
		 * wrong attachment id
		 */

		if ( 'attachment' != get_post_type( $attach_id ) ) {
			return false;
		}

		$width  = intval( $width );
		$height = intval( $height );

		$src_img       = wp_get_attachment_image_src( $attach_id, 'full' );
		$src_img_ratio = $src_img[1] / $src_img[2];
		$src_img_path  = get_attached_file( $attach_id );

		/**
		 * error: if somehow file does not exist ¯\_(ツ)_/¯
		 */

		if ( ! file_exists( $src_img_path ) ) {
			return false;
		}

		/**
		 * create sizes
		 */

		$src_img_info = pathinfo( $src_img_path );

		if ( $crop ) {
			$new_width  = $width;
			$new_height = $height;
		} elseif ( $width / $height <= $src_img_ratio ) {
			$new_width  = $width;
			$new_height = 1 / $src_img_ratio * $width;
		} else {
			$new_width  = $height * $src_img_ratio;
			$new_height = $height;
		}

		$new_width  = round( $new_width );
		$new_height = round( $new_height );

		/**
		 * return the source image if the requested is bigger than the original image
		 */

		if ( $new_width > $src_img[1] || $new_height > $src_img[2] ) {
			return $src_img;
		}

		$new_img_path = "{$src_img_info['dirname']}/{$src_img_info['filename']}-{$new_width}x{$new_height}.{$src_img_info['extension']}";
		$new_img_url  = str_replace( trailingslashit( ABSPATH ), trailingslashit( get_home_url() ), $new_img_path );

		/**
		 * return if already exists
		 */

		if ( file_exists( $new_img_path ) ) {
			return [
				$new_img_url,
				$new_width,
				$new_height,
			];
		}

		/**
		 * crop, save and return image
		 */

		$image = wp_get_image_editor( $src_img_path );
		if ( ! is_wp_error( $image ) ) {
			$image->resize( $width, $height, $crop );
			$image->save( $new_img_path );

			return [
				$new_img_url,
				$new_width,
				$new_height,
			];
		}

		return false;
	}
}
