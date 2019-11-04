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
class Lazysizes
{

	public $init = false;

	public function __construct()
	{
		$this->init = true;
	}

	public function run()
	{
		add_action('wp_head', [$this, 'noscriptCSS'], 50);
		add_action('sht_after_body_open', [$this, 'svgFilter'], 50000);
		add_action('wp_enqueue_scripts', [$this, 'addAssets']);
		add_action('rest_api_init', [$this, 'registerRoute']);
		add_filter('lazy_sizes_size', [$this, 'customLazySizes'], 10, 0);
	}

	public function noscriptCSS()
	{
		echo '<noscript>
		<style type="text/css">
			div.lazyimage__image--lazyload, img.lazyimage__image--lazyload {
				display: none !important;
			}
		</style>
		</noscript>';
	}

	public function svgFilter()
	{
		echo '<svg class="o-lazysizes-svgfilter">
				<filter id="ls-sharp-blur">
					<feGaussianBlur stdDeviation="10"></feGaussianBlur>
					<feColorMatrix type="matrix" values="1 0 0 0 0, 0 1 0 0 0, 0 0 1 0 0, 0 0 0 9 0"></feColorMatrix>
					<feComposite in2="SourceGraphic" operator="in"></feComposite>
				</filter>
			</svg>';
	}

	public function addAssets()
	{
		wp_enqueue_script('lazysizes', get_template_directory_uri() . '/assets/scripts/lazysizes.min.js', [], '3.0.0', true);
		$data = '';
		$data .= 'window.lazySizesConfig = window.lazySizesConfig || {};';
		$data .= "window.lazySizesConfig.lazyClass = 'o-lazyimage__image--lazyload';\n";
		$data .= "window.lazySizesConfig.loadingClass = 'o-lazyimage__image--lazyloading';\n";
		$data .= "window.lazySizesConfig.loadedClass = 'o-lazyimage__image--lazyloaded';\n";
		$data .= "document.addEventListener('lazyloaded', function(e){lazySizesFindParent(e.target).classList.add('o-lazyimage--loaded')});\n";
		$data .= "function lazySizesFindParent (el) { while ((el = el.parentElement) && !el.classList.contains('o-lazyimage')); return el;}\n";

		wp_add_inline_script('lazysizes', $data, 'after');
	}

	/**
	 * returns an image
	 *
	 * @param int|WP_Post $image post_object or post_id of an attachment
	 * @param string|array $size Image size. Accepts any valid image size, or an array of width and height values in pixels (in that order).
	 * @param string $wrapper_class classes for the containing (e.g. figure) tag
	 * @param string $image_class classes for the IMG tag
	 * @param boolean $background if true, a div containing a background image will be reurned instead of the <img>
	 * @param array $attributes an array of additional attributes for the image
	 *
	 * @return string                image or background-image ready to be loaded via lazysizes
	 */
	public static function getLazyImage($image, $size, $wrapper_class = '', $image_class = '', $background = false, $attributes = [])
	{
		$image_object = new LazyImage($image, $size);
		$image_object->setAttributes($attributes);
		if (! empty($wrapper_class)) {
			$image_object->setWrapperClass($wrapper_class);
		}
		if (! empty($image_class)) {
			$image_object->setImageClass($image_class);
		}

		return $image_object->getImage($background);
	}

	public function registerRoute()
	{
		register_rest_route('hello-roots/v1', '/lazy-image/(?P<id>\d+)', [
			'methods'  => 'GET',
			'callback' => function ($data) {

				$size = 'full';
				if (array_key_exists('size', $_GET)) {
					$size = $_GET['size'];
				}

				$image_object = new LazyImage($data['id'], $size);

				$srcs = $image_object->getSrcs();
				if (is_string($srcs)) {
					return new WP_Error('request_failed', $srcs, [
						'status' => 404,
					]);
				}

				return $srcs;
			},
			'args' => [
				'id',
			],
		]);
	}

	public function customLazySizes()
	{
		return [
			'window' => 2560,
			'page' => 1376,
			'large' => 1280,
			'medium' => 330,
			'smallsquare' => 180,
			'small' => 160,
		];
		return $image_object->getImage($background);
	}
}
