<?php

namespace SayHello\Theme\Block;

/**
 * Archive title - search
 * (Not yet available in Core)
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class ArchiveTitleSearch
{

	public function run()
	{
		add_action('init', [$this, 'register']);
	}

	/**
	 * Registers the `sht/archive-title-search` block on the server.
	 */
	public function register()
	{
		register_block_type('sht/archive-title-search', [
			'render_callback' => function ($attributes) {

				if (!empty($attributes['textAlign'] ?? '')) {
					$text_align_class = esc_html("has-text-align-{$attributes['textAlign']}");
					if (!empty($attributes['className'] ?? '')) {
						$attributes['className'] = "{$attributes['className']} {$text_align_class}";
					} else {
						$attributes['className'] = $text_align_class;
					}
				}

				ob_start();
				if (sht_theme()->Package->Gutenberg->isContextEdit()) {
?>
				<h2>Archive title - search</h2>
<?php
				} elseif (is_search()) {
					printf(
						'<h1 class="%s">%s</h1>',
						esc_html($attributes['className'] ?? ''),
						get_the_archive_title()
					);
				}
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
			}
		]);
	}
}
