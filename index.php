<?php

get_header();
if (have_posts()) {
	?>
	<section class="c-archive c-content">

		<div class="c-archive__content c-content__content">
			<?php
			while (have_posts()) {
				the_post();
				get_template_part('partials/excerpt', get_post_type());
			}
			?>
		</div>
	</section>
	<?php
} else {
	get_template_part('partials/singular', 'none');
}
get_footer();
