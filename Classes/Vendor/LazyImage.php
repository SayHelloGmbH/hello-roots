<?php

namespace SayHello\Theme\Vendor;

class LazyImage
{

	public $image_id             = 0;
	public $wp_size              = '';
	public $error                = false;
	public $attributes           = [];
	public $image_full           = [];
	public $image_org            = [];
	public $image_pre_src        = '';
	protected $image_pre_width   = 30;
	protected $image_pre_quality = 30;
	public $image_aspect         = 0;
	public $image_srcset         = [];
	public $wrapper_class        = '';
	public $is_svg               = false;

	public $ls_transparent = false;
	public $ls_background  = 'transparent';
	public $ls_sizes       = [];

	public function __construct($image, $size)
	{
		if (is_array($image)) {
			$image = (int) $image['id'];
		}

		if (! $image) {
			return;
		}

		$this->ls_transparent = apply_filters('lazy_sizes_transparent', $this->ls_transparent);
		if ($this->ls_transparent) {
			$this->ls_background = 'currentColor';
		}
		$this->ls_background = apply_filters('lazy_sizes_background', $this->ls_background);
		$this->ls_sizes      = apply_filters(
			'lazy_sizes_size',
			[
				'window' => 2000,
				'page'   => 1200,
				'large'  => 640,
				'medium' => 320,
				'small'  => 160,
			]
		);

		$this->set_image_id($image);
		$this->set_wp_size($size);
	}

	/**
	 * Setters
	 */

	private function set_image_id($image)
	{
		if ($this->error) {
			return;
		}

		$post           = get_post($image);
		$this->image_id = isset($post->ID) ? $post->ID : 0;
		if ('attachment' !== get_post_type($this->image_id)) {
			$this->error = 'Invalid Image ID';
		} elseif (strpos(get_post_mime_type($this->image_id), 'image') !== 0) {
			$this->error = 'Invalid Image mime type';
		}

		if ($this->error) {
			return;
		}

		if ('image/svg+xml' == get_post_mime_type($this->image_id)) {
			$this->is_svg = true;
		}

		$this->image_full = wp_get_attachment_image_src($this->image_id, 'full');
	}

	private function set_wp_size($size)
	{
		if ($this->error) {
			return;
		}

		$check = $this->check_image_size($size);
		if ('' !== $check) {
			$this->error = $check;

			return;
		}
		$this->wp_size = $size;

		/**
		 * Org Image
		 */

		if ($this->is_svg) {
			$this->image_org     = $this->image_full;
			$this->image_pre_src = $this->image_org[0];

			return;
		}

		$this->image_org = [];

		if ('full' == $size) {
			$this->image_org    = $this->image_full;
			$this->image_aspect = $this->image_org[1] / $this->image_org[2];
		} else {
			if (is_array($size)) {
				$org_width  = $size[0];
				$org_height = $size[1];
			} else {
				$org_width  = $this->get_wp_image_sizes()[ $size ]['width'];
				$org_height = $this->get_wp_image_sizes()[ $size ]['height'];
			}

			$this->image_aspect = $org_width / $org_height;

			if ($org_width > $this->image_full[1]) {
				$org_width  = $this->image_full[1];
				$org_height = $org_width / $this->image_aspect;
			}
			if ($org_height > $this->image_full[2]) {
				$org_height = $this->image_full[2];
				$org_width  = $this->image_full[2] * $this->image_aspect;
			}

			$this->image_org = $this->generate_image($this->image_id, $org_width, $org_height, true);
		}

		/**
		 * Srcset
		 */

		$this->image_srcset                        = [];
		$this->image_srcset[ $this->image_org[1] ] = $this->image_org[0];

		foreach ($this->get_ls_sizes() as $key => $width) {
			if ($width > $this->image_org[1]) {
				continue;
			}

			$image_width  = $width;
			$image_height = $width / $this->image_aspect;
			$new_image    = $this->generate_image($this->image_id, $image_width, $image_height, true);

			$this->image_srcset[ $width ] = $new_image[0];
		}

		/**
		 * Preview
		 */

		$prev_width  = $this->image_pre_width;
		$prev_height = $prev_width / $this->image_aspect;

		if ($this->ls_transparent) {
			$gcd                 = $this->greatest_common_divisor($prev_width, $prev_height);
			$prev_width          = $prev_width / $gcd;
			$prev_height         = $prev_height / $gcd;
			$this->image_pre_src = $this->generate_placeholder_image($prev_width, $prev_height, 'transparent');
		} else {
			$this->image_pre_src = $this->generate_image($this->image_id, $prev_width, $prev_height, true, $this->image_pre_quality)[0];
		}
	}

	public function set_wrapper_class($class = '')
	{
		if ($this->error) {
			return;
		}

		$this->wrapper_class = $class;
	}

	public function set_attributes($attributes)
	{
		if ($this->error) {
			return;
		}

		if (! is_array($attributes)) {
			$this->attributes = 'additional attributes should to be an array';
		}

		$this->attributes = $attributes;
	}

	/**
	 * Getters
	 */

	public function get_image($background = false)
	{
		if ($this->error) {
			return $this->error;
		}

		$srcset = [];
		foreach ($this->image_srcset as $setsize => $seturl) {
			$srcset[] = $seturl . ' ' . $setsize . 'w';
		}
		$srcset = implode(', ', $srcset);

		$atts = [];
		foreach ($this->attributes() as $key => $val) {
			$key    = sanitize_title($key);
			$val    = esc_attr($val);
			$atts[] = "$key='$val'";
		}
		$atts = implode(' ', $atts);

		$return = '';

		$class = 'lazyimage';
		if ($this->ls_transparent) {
			$class .= ' lazyimage--transparent';
		}
		if ($background) {
			$class .= ' lazyimage--background';
		}
		if ($this->is_svg) {
			$class .= ' lazyimage--svg';
		}
		if ('' !== $this->wrapper_class) {
			$class .= " {$this->wrapper_class}";
		}

		if ($this->is_svg) {
			$this->ls_background = 'transparent';
		}

		$return .= "<figure class='{$class}' style='background-color: {$this->ls_background}'>";
		if ($background) {
			if (! $this->ls_transparent && ! $this->is_svg) {
				$return .= "<div class='lazyimage__preview' style='background-image: url($this->image_pre_src);'></div>";
			}
			$return .= "<div {$atts} class='lazyimage__image lazyimage__image--lazyload' style='background-image: url($this->image_pre_src);' data-bgset='{$srcset}'></div>";
			$return .= "<noscript><div {$atts} style='background-image: url({$this->image_org[0]})'></div></noscript>";
		} else {
			if (! $this->ls_transparent && ! $this->is_svg) {
				$return .= "<img class='lazyimage__preview' src='{$this->image_pre_src}'/>";
			}
			$return .= "<img {$atts} class='lazyimage__image lazyimage__image--lazyload' data-sizes='auto' src='{$this->image_pre_src}' data-srcset='$srcset'/>";
			$return .= "<noscript><img {$atts} src='{$this->image_org[0]}' srcset='$srcset'/></noscript>";
		}
		$return .= '</figure>';

		return $return;
	}

	/**
	 * Helpers
	 */

	private function check_image_size($size)
	{
		if ('full' == $size) {
			return '';
		} elseif (is_array($size) && 2 == count($size)) {
			if (intval($size[0]) == 0 || intval($size[1]) == 0) {
				return "invalid width: '{$size[0]}' or height: '{$size[1]}''";
			}
		} elseif (! array_key_exists($size, $this->get_wp_image_sizes())) {
			return "Invalid image size '$size'";
		}

		return '';
	}

	private function get_wp_image_sizes()
	{
		global $_wp_additional_image_sizes;

		$sizes = [];

		foreach (get_intermediate_image_sizes() as $_size) {
			if (in_array($_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ))) {
				$sizes[ $_size ]['width']  = get_option("{$_size}_size_w");
				$sizes[ $_size ]['height'] = get_option("{$_size}_size_h");
				$sizes[ $_size ]['crop']   = (bool) get_option("{$_size}_crop");
			} elseif (isset($_wp_additional_image_sizes[ $_size ])) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}

	private function get_ls_sizes()
	{
		$sizes = $this->ls_sizes;

		foreach ($sizes as $key => $size) {
			$size = intval($size);
			if (0 == $size) {
				echo "LazySizes Size \"$key\" has to be an integer";
				die();
			}
			$sizes[ $key ] = $size;
		}
		arsort($sizes);

		return $sizes;
	}

	private function generate_image($attach_id, $width, $height, $crop = false, $quality = false)
	{

		/**
		 * wrong attachment id
		 */

		if ('attachment' !== get_post_type($attach_id)) {
			return false;
		}

		$width  = intval($width);
		$height = intval($height);

		$src_img       = wp_get_attachment_image_src($attach_id, 'full');
		$src_img_ratio = $src_img[1] / $src_img[2];
		$src_img_path  = get_attached_file($attach_id);

		/**
		 * error: if somehow file does not exist ¯\_(ツ)_/¯
		 */

		if (! file_exists($src_img_path)) {
			return false;
		}

		/**
		 * create sizes
		 */

		$src_img_info = pathinfo($src_img_path);

		if ($crop) {
			$new_width  = $width;
			$new_height = $height;
		} elseif ($width / $height <= $src_img_ratio) {
			$new_width  = $width;
			$new_height = 1 / $src_img_ratio * $width;
		} else {
			$new_width  = $height * $src_img_ratio;
			$new_height = $height;
		}

		if ($new_width <= 1) {
			$new_width = 1;
		}
		if ($new_height <= 1) {
			$new_height = 1;
		}

		$new_width  = round($new_width);
		$new_height = round($new_height);

		/**
		 * return the source image if the requested is bigger than the original image
		 */

		if ($new_width > $src_img[1] || $new_height > $src_img[2]) {
			return $src_img;
		}

		$quality = intval($quality);
		if (0 == $quality) {
			$quality = false;
		}

		$new_img_path = "{$src_img_info['dirname']}/{$src_img_info['filename']}-{$new_width}x{$new_height}.{$src_img_info['extension']}";
		if ($quality) {
			$new_img_path = "{$src_img_info['dirname']}/{$src_img_info['filename']}-{$new_width}x{$new_height}-q{$quality}.{$src_img_info['extension']}";
		}
		$new_img_url = str_replace(trailingslashit(ABSPATH), trailingslashit(get_site_url()), $new_img_path);

		/**
		 * return if already exists
		 */

		if (file_exists($new_img_path)) {
			return [
				$new_img_url,
				$new_width,
				$new_height,
			];
		}

		/**
		 * crop, save and return image
		 */

		$image = wp_get_image_editor($src_img_path);
		if (! is_wp_error($image)) {
			$image->resize($width, $height, $crop);
			if ($quality) {
				$image->set_quality($quality);
			}
			$image->save($new_img_path);

			return [
				$new_img_url,
				$new_width,
				$new_height,
			];
		}

		return false;
	}

	private function generate_placeholder_image($width = 1, $height = 1, $color = 'transparent')
	{
		$width  = intval($width);
		$height = intval($height);

		$upload_dir = wp_upload_dir();
		$folder     = "{$upload_dir['basedir']}/transparent-placeholder";
		if (! is_dir($folder)) {
			mkdir($folder);
		}

		$path = "{$folder}/{$width}x{$height}.gif";
		$url  = "{$upload_dir['baseurl']}/transparent-placeholder/{$width}x{$height}.gif";

		if (is_file($path)) {
			return $url;
		}

		ob_start();
		$img   = imagecreatetruecolor($width, $height);
		$black = imagecolorallocate($img, 0, 0, 0);
		imagecolortransparent($img, $black);
		imagegif($img, null);

		$imagedata = ob_get_contents();

		ob_end_clean();

		$put = file_put_contents($path, $imagedata);
		if ($put) {
			return $url;
		}

		return false;
	}

	private function greatest_common_divisor($num1, $num2)
	{
		while (0 !== $num2) {
			$t    = $num1 % $num2;
			$num1 = $num2;
			$num2 = $t;
		}

		return $num1;
	}

	private function attributes()
	{
		if (! $this->image_id) {
			return [];
		}

		$attr = array_merge(
			[
				'width'  => $this->image_org[1],
				'height' => $this->image_org[2],
				'alt'    => trim(strip_tags(get_post_meta($this->image_id, '_wp_attachment_image_alt', true))),
			],
			$this->attributes
		);

		return apply_filters('wp_get_attachment_image_attributes', $attr, $this->image_id, $this->wp_size);
	}
}
