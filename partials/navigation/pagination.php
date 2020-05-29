<?php
$paginate = paginate_links();
if ('' !== $paginate) {
	printf('<div class="c-pagination">
		<div class="c-pagination__content">%s</div>
	</div>', $paginate);
}
