<?php

namespace SayHello\Theme\Package;

use SayHello\Theme\Vendor\LazyImage;

// use DomDocument;
// use DOMElement;
// use DOMXPath;

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
		add_action('wp_enqueue_scripts', [$this, 'addAssets']);
		add_action('rest_api_init', [$this, 'registerRoute']);
		add_filter('lazy_sizes_size', [$this, 'customLazySizesBreakpoints'], 10, 0);
		//add_filter('the_content', [$this, 'makeImageBlocksLazy']); // ask mark - work in progress
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
			'permission_callback' => '__return_true',
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

	public function customLazySizesBreakpoints()
	{
		return [
			'window' => 2560,
			'page' => 1440,
			'large' => 1280,
			'medium' => 768,
			'small' => 320,
		];
		return $image_object->getImage($background);
	}

	// public function makeImageBlocksLazy($content)
	// {
	// 	if (!has_block('core/image') || empty($content)) {
	// 		return $content;
	// 	}
	// 	libxml_use_internal_errors(true);
	// 	$domDocument = new DOMDocument();
	// 	$domDocument->preserveWhiteSpace = false;
	// 	$domDocument->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
	//
	// 	$xpath = new DOMXpath($domDocument);
	// 	$blocks = $xpath->query("//figure[contains(concat(' ',normalize-space(@class),' '),' wp-block-image ')]");
	//
	// 	if (!count($blocks)) {
	// 		return $content;
	// 	}
	//
	// 	foreach ($blocks as $block) {
	// 		$figure_class = $block->getAttribute('class');
	// 		$images = $xpath->query('.//img', $block);
	// 		if (!$images || !$images[0]) {
	// 			continue;
	// 		}
	// 		$image = $images[0];
	// 		$image_class = $image->getAttribute('class');
	// 		preg_match('~wp-image-([0-9]+)~', $image_class, $matches);
	// 		if (count($matches) === 2) {
	// 			$image_id = $matches[1];
	// 			$lazy_image = Lazysizes::getLazyImage($image_id, 'full', '', $image_class);
	//
	// 			$tpl = new DOMDocument;
	// 			$tpl->loadHTML($lazy_image);
	// 			$new_figure = $domDocument->importNode($tpl->documentElement->getElementsByTagName('figure')->item(0), true);
	//
	// 			$wrapper = $domDocument->createElement('div');
	// 			$wrapper->setAttribute('class', $figure_class);
	//
	// 			foreach ($block->childNodes as $child) {
	// 				if (strtolower($child->tagName) === 'a') {
	// 					$link = $child->cloneNode(false); // Just the link tag, not its childNodes
	// 					$images = $xpath->query(".//img[contains(concat(' ',normalize-space(@class),' '),' o-lazyimage__image ')]", $new_figure);
	// 					foreach ($images as $image) {
	// 						$link->appendChild($image);
	// 					}
	// 					$new_figure->insertBefore($link, $new_figure->firstChild->nextSibling);
	// 					break;
	// 				}
	// 			}
	//
	// 			$wrapper->appendChild($new_figure);
	//
	// 			$figcaption = $xpath->query('.//figcaption', $block);
	// 			if ((int) $figcaption->length ?? 0) {
	// 				$new_cap = $figcaption[0]->cloneNode(true);
	// 				$wrapper->appendChild($new_cap);
	// 			}
	//
	// 			$block->parentNode->insertBefore($wrapper, $block);
	// 			$block->parentNode->removeChild($block);
	// 		}
	// 	}
	// 	$body = $domDocument->saveHtml($domDocument->getElementsByTagName('body')->item(0));
	// 	$content = str_replace([ '<body>', '</body>' ], '', $body);
	// 	return $content;
	// }
}
