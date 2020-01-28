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
		add_filter('get_the_archive_title', [$this, 'archiveTitle']);
	}

	public function archiveTitle($title)
	{
		if (is_category()) {
			/* translators: Category archive title. %s: Category name */
			$title = sprintf(_x('Beiträge aus der Kategorie «%s»', 'Archive title category', 'sht'), single_cat_title('', false));
		} elseif (is_tag()) {
			/* translators: Tag archive title. %s: Tag name */
			$title = sprintf(_x('Beiträge mit dem Schlagwort «%s»', 'Archive title tag', 'sht'), single_tag_title('', false));
		} elseif (is_author()) {
			/* translators: Author archive title. %s: Author name */
			$title = sprintf(_x('Beiträge von %s', 'Archive title author', 'sht'), '<span class="vcard">' . get_the_author() . '</span>');
		} elseif (is_year()) {
			/* translators: Yearly archive title. %s: Year */
			$title = sprintf(_x('Beiträge aus %s', 'Archive title year', 'sht'), get_the_date(_x('Y', 'yearly archives date format', 'sht')));
		} elseif (is_month()) {
			/* translators: Monthly archive title. %s: Month name and year */
			$title = sprintf(_x('Beiträge aus %s', 'Archive title month/year', 'sht'), get_the_date(_x('F Y', 'monthly archives date format', 'sht')));
		} elseif (is_day()) {
			/* translators: Daily archive title. %s: Date */
			$title = sprintf(_x('Posts from %s', 'Archive title day month year', 'sht'), get_the_date(_x('j. F Y', 'daily archives date format', 'sht')));
		} elseif (is_tax('post_format')) {
			// if (is_tax('post_format', 'post-format-aside')) {
			// 	$title = _x('Asides', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-gallery')) {
			// 	$title = _x('Galleries', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-image')) {
			// 	$title = _x('Images', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-video')) {
			// 	$title = _x('Videos', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-quote')) {
			// 	$title = _x('Quotes', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-link')) {
			// 	$title = _x('Links', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-status')) {
			// 	$title = _x('Statuses', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-audio')) {
			// 	$title = _x('Audio', 'post format archive title', 'sht');
			// } elseif (is_tax('post_format', 'post-format-chat')) {
			// 	$title = _x('Chats', 'post format archive title', 'sht');
			// }
		} elseif (is_post_type_archive()) {
			/* translators: Post type archive title. %s: Post type name */
			$title = sprintf(_x('%s Archives', 'Archive title post type archive', 'sht'), post_type_archive_title('', false));
		} elseif (is_tax()) {
			$tax = get_taxonomy(get_queried_object()->taxonomy);
			/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf(_x('%1$s: %2$s', 'Archive title taxonomy archive', 'sht'), $tax->labels->singular_name, single_term_title('', false));
		} else {
			$title = _x('Archiv', 'Archive title default', 'sht');
		}
		return $title;
	}
}
