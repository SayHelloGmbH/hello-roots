<?php

namespace SayHello\Theme\Package;

use enshrined\svgSanitize\Sanitizer;

/**
 * Implements SVG Support to WordPress, cleaning SVG Files before they are saved.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class SVG
{


	/**
	 * Hooks the upload_mimes and wp_handle_upload_prefilter filter.
	 * Hooks the admin_enqueue_scripts action.
	 *
	 * @return void
	 */
	public function run()
	{
		add_filter('upload_mimes', array( $this, 'allowSvgUpload' ));
		add_filter('wp_handle_upload_prefilter', array( $this, 'sanitizeSvg' ));
		add_action('admin_enqueue_scripts', array( $this, 'addSvgStyles' ));
		add_filter('wp_get_attachment_image_src', [ $this, 'fixWpGetAttachmentImageSvg' ], 10, 3);
	}

	/**
	 * Adds inline Style to properly display SVG files.
	 *
	 * @return void
	 */
	public function addSvgStyles()
	{
		wp_add_inline_style('wp-admin', "img.attachment-80x60[src$='.svg'] { width: 100%; height: auto; }");
	}

	/**
	 * Adds the 'image/svg+xml' mime type to the list of allowed upload filetypes.
	 *
	 * @param  Array $mimeTypes Allowed mime types.
	 * @return Array             Allowed mime types with SVGs.
	 */
	public function allowSvgUpload($mimeTypes)
	{
		$mimeTypes['svg'] = 'image/svg+xml';

		return $mimeTypes;
	}

	/**
	 * Sanitizes a SVG file before it's saved to the server storage.
	 * This removes unallowed tags and scripts.
	 *
	 * @see    enshrined\svgSanitize\Sanitizer
	 * @param  Array $file Uploaded file.
	 * @return Array        Cleaned file if type is SVG.
	 */
	public function sanitizeSvg($file)
	{
		if ($file['type'] == 'image/svg+xml') {
			$sanitizer    = new Sanitizer();
			$dirtySVG     = file_get_contents($file['tmp_name']);
			$sanitizedSvg = $sanitizer->sanitize($dirtySVG);

			global $wp_filesystem;
			$credentials = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());
			if (! WP_Filesystem($credentials)) {
				request_filesystem_credentials(site_url() . '/wp-admin/', '', true, false, null);
			}

			// Using the filesystem API provided by WordPress, we replace the contents of the temporary file and then let the process continue as normal.
			$wp_filesystem->put_contents($file['tmp_name'], $sanitizedSvg, FS_CHMOD_FILE);
		}

		return $file;
	}

	/**
	 * this function returns a i-Tag with an SVG-Icon inside
	 *
	 * @since 0.0.1
	 *
	 * @param string $icon    icon filename or path
	 * @param array  $classes array of classes that will be added
	 *
	 * @return string          <i ...><svg ...></svg></i>
	 */
	public function getIcon($icon, $classes = [])
	{

		$path_min = get_template_directory() . "/assets/img/icons/$icon.min.svg";
		$path     = get_template_directory() . "/assets/img/icons/$icon.svg";

		$classes = array_merge([ 'hello-icon' ], $classes);

		if (file_exists($path_min)) {
			return '<i class="' . implode(' ', $classes) . '">' . file_get_contents($path_min) . '</i>';
		} elseif (file_exists($path)) {
			return '<i class="' . implode(' ', $classes) . '">' . file_get_contents($path) . '</i>';
		} else {
			return 'icon not found ' . $path_min . ' / ' . $path;
		}
	}

	public function fixWpGetAttachmentImageSvg($image, $attachment_id, $size)
	{
		if (is_array($image) && preg_match('/\.svg$/i', $image[0]) && $image[1] <= 1) {
			if (is_array($size)) {
				$image[1] = $size[0];
				$image[2] = $size[1];
			} elseif (( $xml = simplexml_load_file($image[0]) ) !== false) {
				$attr     = $xml->attributes();
				$viewbox  = explode(' ', $attr->viewBox);
				$image[1] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : ( count($viewbox) == 4 ? (int) $viewbox[2] : null );
				$image[2] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : ( count($viewbox) == 4 ? (int) $viewbox[3] : null );
			} else {
				$image[1] = null;
				$image[2] = null;
			}
		}

		return $image;
	}

	/**
	 * This function check if a given attachment ID is a svg or not
	 *
	 * @since 0.1.0
	 *
	 * @param $attachment_id
	 *
	 * @return bool
	 */
	public function isSVG($attachment_id)
	{
		if ('attachment' !== get_post_type($attachment_id)) {
			return false;
		}

		return 'image/svg+xml' === get_post_mime_type($attachment_id);
	}
}
