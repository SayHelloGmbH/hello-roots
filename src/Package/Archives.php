<?php

namespace SayHello\Theme\Package;

/**
 * Post archives
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
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
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Newsbeiträge aus der Kategorie', 'Archive title category', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_tag()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Newsbeiträge mit dem Schlagwort', 'Archive title post tag', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_author()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Newsbeiträge von', 'Archive title author', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_year()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Newsbeiträge aus', 'Archive title year', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_month()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Newsbeiträge aus', 'Archive title month/year', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_day()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Newsbeiträge aus', 'Archive title day', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_post_type_archive()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Beitragsarchiv', 'CPT archive title', 'sht')
			);
			$title = ' '.$original_title;
		} elseif (is_tax()) {
			$prefix = sprintf(
				'<span class="c-archive__titleprefix">%s</span>',
				_x('Beiträge aus der Kategorie', 'Archive title year', 'sht')
			);
			$title = ' '.$original_title;
		} else {
			$title = _x('Neueste Newsbeiträge', 'Archive title default', 'sht');
		}
		return $prefix . $title;
	}
}
