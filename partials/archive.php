<section class="c-archive c-content">

	<div class="c-archive__content c-content__content">

		<header class="c-archive__header">
			<?php the_archive_title('<h1 class="c-archive__title">', '</h1>'); ?>
		</header>

		<div class="c-archive__content">
			<?php
			if (have_posts()) {
				while (have_posts()) {
					the_post();
					get_template_part('partials/excerpt', get_post_type());
				}
			}
			?>
		</div>

		<?php
		$paginate = paginate_links();
		if ('' != $paginate) {
			echo '<div class="c-pagination">';
			echo '<div class="c-pagination__content">' .$paginate. '</div>';
			echo '</div>';
		}
		?>
	</div>

</section>
