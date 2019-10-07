<article itemscope itemtype="http://schema.org/BlogPosting" class="c-excerpt c-excerpt--<?php echo get_post_type(); ?>">

	<header class="c-excerpt__header">
		<h2 class="c-excerpt__title">
			<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
				<?php the_title(); ?>
			</a>
		</h2>
	</header>

	<div class="c-excerpt__content">
		<?php the_excerpt(); ?>
	</div>

	<footer class="c-excerpt__footer">
		<p>
			<?php
			// translators: published at %1$1s and by %2$2s
			printf(
				__('Published at %1$1s by %2$2s', 'sht'),
				get_the_date(),
				'<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author() . '</a>'
			);
			?>
		</p>
	</footer>

</article>
