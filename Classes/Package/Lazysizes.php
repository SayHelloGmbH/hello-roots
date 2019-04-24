<?php

namespace SayHello\Theme\Package;

use SayHello\Theme\Vendor\LazyImage;

/**
 * This Class provides advanced media loading possibilities via lazysizes.
 * Please make sure you included https://github.com/aFarkas/lazysizes/ so the images are loaded via JS.
 * <noscript> Fallback is provided as well
 *
 * @author Nico Martin <nico@sayhello.ch>
 */

class Lazysizes {


	public $init = false;

	public function __construct() {
		$this->init = true;
	}

	public function run() {
		add_action( 'wp_head', [ $this, 'noscriptCSS' ], 50 );
		add_action( 'sht_after_body_open', [ $this, 'svgFilter' ], 50000 );
		add_action( 'wp_enqueue_scripts', [ $this, 'addAssets' ] );
	}

	public function noscriptCSS() {
		echo '<noscript>
		<style type="text/css">
			div.lazyimage__image--lazyload, img.lazyimage__image--lazyload {
				display: none !important;
			}
		</style>
		</noscript>';
	}

	public function svgFilter() {
		echo '<svg class="lazysizes-svgfilter">
				<filter id="ls-sharp-blur">
					<feGaussianBlur stdDeviation="10"></feGaussianBlur>
					<feColorMatrix type="matrix" values="1 0 0 0 0, 0 1 0 0 0, 0 0 1 0 0, 0 0 0 9 0"></feColorMatrix>
					<feComposite in2="SourceGraphic" operator="in"></feComposite>
				</filter>
			</svg>';
	}

	public function addAssets() {
		wp_enqueue_script( 'lazysizes', get_template_directory_uri() . '/assets/scripts/lazysizes.min.js', [], '3.0.0', true );
		$data  = '';
		$data .= 'window.lazySizesConfig = window.lazySizesConfig || {};';
		$data .= "window.lazySizesConfig.lazyClass = 'lazyimage__image--lazyload';\n";
		$data .= "window.lazySizesConfig.loadingClass = 'lazyimage__image--lazyloading';\n";
		$data .= "window.lazySizesConfig.loadedClass = 'lazyimage__image--lazyloaded';\n";
		//$data .= "document.addEventListener('lazyloaded', function(e){console.log(lazySizesFindParent(e.target).classList.add('lazyimage--loaded'))});\n";
		//$data .= "function lazySizesFindParent (el) { while ((el = el.parentElement) && !el.classList.contains('lazyimage')); return el;}\n";

		wp_add_inline_script( 'lazysizes', $data, 'after' );
	}

	/**
	 * returns an image
	 *
	 * @param int|WP_Post  $image      post_object or post_id of an attachment
	 * @param string|array $size       Image size. Accepts any valid image size, or an array of width and height values in pixels (in that order).
	 * @param string       $class      classes
	 * @param boolean      $background if true, a div containing a background image will be reurned instead of the <img>
	 * @param array        $attributes an array of additional attributes for the image
	 *
	 * @return string                image or background-image ready to be loaded via lazysizes
	 */
	public static function getLazyImage( $image, $size, $class = '', $background = false, $attributes = [] ) {
		$image_object = new LazyImage( $image, $size );
		$image_object->set_wrapper_class( $class );
		$image_object->set_attributes( $attributes );

		return $image_object->get_image( $background );
	}
}
