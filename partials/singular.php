<article <?php post_class('c-content c-article c-article--'.get_post_type()); ?>>

	<div class="c-content__content">
		<?php
		if (!(bool) get_field('hide_title', get_the_ID())) {
			?>
			<header class="c-article__header">
				<h1 class="c-article__title"><?php the_title(); ?></h1>
				<time class="c-article__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
			</header>
			<?php
		}
		the_content();
		?>
	</div>

	<?php
		get_template_part('partials/navigation/pagelinks');
		get_template_part('partials/meta/category');
		get_template_part('partials/meta/post_tag');
	?>

</article>
