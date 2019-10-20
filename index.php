<?php

get_header();
if (have_posts()) {
	?>
	<div class="c-archive">
		<?php
		while (have_posts()) {
			the_post();
			get_template_part('partials/excerpt', get_post_type());
		}
		?>
	</div>
	<?php
} else {
	get_template_part('partials/singular', 'none');
}
get_footer();
