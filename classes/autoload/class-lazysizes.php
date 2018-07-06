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

	public function __construct() {
		$this->init = true;
	}

	public function run() {
		add_action( 'wp_head', [ $this, 'noscript_css' ], 50 );
		add_action( 'sht_after_body_open', [ $this, 'svg_filter' ], 50000 );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_assets' ] );
	}

	public function noscript_css() {
		?>
		<noscript>
			<style type="text/css">
				div.lazyimage__image--lazyload, img.lazyimage__image--lazyload {
					display: none !important;
				}
			</style>
		</noscript>
		<?php
	}

	public function svg_filter() {
		?>
		<svg class="lazysizes-svgfilter">
			<filter id="ls-sharp-blur">
				<feGaussianBlur stdDeviation="10"></feGaussianBlur>
				<feColorMatrix type="matrix" values="1 0 0 0 0, 0 1 0 0 0, 0 0 1 0 0, 0 0 0 9 0"></feColorMatrix>
				<feComposite in2="SourceGraphic" operator='in'></feComposite>
			</filter>
		</svg>
		<?php
	}

	public function add_assets() {
		wp_enqueue_script( 'lazysizes', get_template_directory_uri() . '/assets/scripts/lazysizes.min.js', [], '3.0.0', true );
		$data = '';
		$data .= 'window.lazySizesConfig = window.lazySizesConfig || {};';
		$data .= "window.lazySizesConfig.lazyClass = 'lazyimage__image--lazyload';\n";
		$data .= "window.lazySizesConfig.loadingClass = 'lazyimage__image--lazyloading';\n";
		$data .= "window.lazySizesConfig.loadedClass = 'lazyimage__image--lazyloaded';\n";
		//$data .= "document.addEventListener('lazyloaded', function(e){console.log(lazySizesFindParent(e.target).classList.add('lazyimage--loaded'))});\n";
		//$data .= "function lazySizesFindParent (el) { while ((el = el.parentElement) && !el.classList.contains('lazyimage')); return el;}\n";

		wp_add_inline_script( 'lazysizes', $data, 'after' );
	}
}
