<article <?php post_class('c-article c-article--'.get_post_type()); ?>>

	<div class="c-article__content c-blocks c-constraint">
		<?php
		if (!(bool) get_post_meta(get_the_ID(), 'hide_title', true)) {
			?>
			<header class="c-article__header">
				<h1 class="c-article__title"><?php the_title(); ?></h1>
			</header>
			<?php
		}?>
		<?php the_content(); ?>
	</div>

	<?php
		get_template_part('partials/navigation/pagelinks');
		get_template_part('partials/comments/template');
	?>

</article>
