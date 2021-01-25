<article <?php post_class('c-article c-article--' . get_post_type()); ?>>

	<div class="c-article__content c-article__content--<?php echo get_post_type(); ?> c-blocks c-constraint">
		<?php the_content(); ?>
	</div>

	<?php
	get_template_part('partials/navigation/pagelinks');
	get_template_part('partials/comments/template');
	?>

</article>
