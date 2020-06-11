<article <?php post_class('c-article c-article--'.get_post_type()); ?>>

	<div class="c-article__content c-blocks c-constraint">
		<?php
		if (!(bool) get_post_meta(get_the_ID(), 'hide_title', true)) {
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

	<div class="c-constraint">
		<?php
			get_template_part('partials/navigation/pagelinks');
			get_template_part('partials/meta/category');
			get_template_part('partials/meta/post_tag');
			get_template_part('partials/comments/template');
		?>
	</div>

</article>
