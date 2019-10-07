<article <?php post_class('c-article'); ?>>

	<header class="c-article__header">
		<h1 class="c-article__title"><?php the_title(); ?></h1>
		<time class="c-article__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
	</header>

	<?php
	echo sht_theme()->Package->View->thumbnail('large', 'c-article__thumbnail');
	?>

	<div class="c-content__content">
		<?php the_content(); ?>
	</div>

	<?php
		get_template_part('partials/meta', 'post_tag');
	?>

</article>
