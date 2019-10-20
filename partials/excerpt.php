<article itemscope itemtype="http://schema.org/BlogPosting" class="c-excerpt c-excerpt--<?php echo get_post_type(); ?>">

	<header class="c-excerpt__header">
		<h2 class="c-excerpt__title">
			<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
				<?php the_title(); ?>
			</a>
		</h2>
		<time class="c-excerpt__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
	</header>

	<div class="c-excerpt__content">
		<?php the_excerpt(); ?>
	</div>

	<a class="c-excerpt__more" href="<?php the_permalink(); ?>"><?php _ex('Read more', 'Excerpt read more link', 'sht')?></a>

</article>
