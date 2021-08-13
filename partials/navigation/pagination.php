<?php
/**
 * Simple version without first/last links
 
$paginate = paginate_links();
if ('' !== $paginate) {
	printf('<div class="c-pagination">
		<div class="c-pagination__content">%s</div>
	</div>', $paginate);
}
 * 
 **/

$paginate = paginate_links([
	'type' => 'array'
]);

global $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$first_text = _x('Erste Seite', 'Pagination link text', 'sht');
$last_text = _x('Letzte Seite', 'Pagination link text', 'sht');
$base_url = get_post_type_archive_link(get_post_type());
$last = intval($wp_query->max_num_pages);
$first_url = esc_url(get_pagenum_link(1));
$last_url = esc_url(get_pagenum_link($last));

if ($paged === 1) {
	$paginate[] = "<a class=\"page-numbers last\" href=\"{$last_url}\">{$last_text}</a>";
} elseif ($paged === $last) {
	array_unshift($paginate, "<a class=\"page-numbers first\" href=\"{$first_url}\">{$first_text}</a>");
} else {
	$paginate[] = "<a class=\"page-numbers last\" href=\"{$last_url}\">{$last_text}</a>";
	array_unshift($paginate, "<a class=\"page-numbers first\" href=\"{$first_url}\">{$first_text}</a>");
}

if (!empty($paginate)) {
	printf('<div class="c-archive__pagination c-pagination">
				<div class="c-archive__paginationcontent c-pagination__content">%s</div>
			</div>', implode(chr(10), $paginate));
}
