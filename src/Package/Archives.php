<?php

namespace SayHello\Theme\Package;

/**
 * Post archives
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Archives
{

	public function run()
	{
		add_filter('get_the_archive_title', [$this, 'archiveTitle'], 10, 3);
	}

	public function archiveTitle($title, $original_title, $prefix)
	{
		if (is_category()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge aus der Kategorie', 'Archive title category', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_tag()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge mit dem Schlagwort', 'Archive title post tag', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_author()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge von', 'Archive title author', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_year()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge aus', 'Archive title year', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_month()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge aus', 'Archive title month/year', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_day()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge aus', 'Archive title day', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_post_type_archive()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beitragsarchiv', 'CPT archive title', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_tax()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Beiträge aus der Kategorie', 'Archive title year', 'sht')
			);
			$title = ' ' . $original_title;
		} elseif (is_search()) {
			$prefix = sprintf(
				'<span class="wp-block-query-title__prefix">%s</span>',
				_x('Suchergebnisse für', 'Archive title year', 'sht')
			);
			$title = ' ' . _x('«', 'Quote left', 'sht') . esc_html(get_search_query()) . _x('»', 'Quote right', 'sht');
		} else {
			$title = _x('Neueste Beiträge', 'Archive title default', 'sht');
		}
		return $prefix . $title;
	}
}
