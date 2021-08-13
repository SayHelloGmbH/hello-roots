<?php

// Pagination HTML is modified by default through
// the Navigation Package, to include SVG links for
// first/last/next/previous pages

$paginate = paginate_links();
if ($paginate !== '') {
	printf('<div class="c-pagination">
		<div class="c-pagination__content">%s</div>
	</div>', $paginate);
}
