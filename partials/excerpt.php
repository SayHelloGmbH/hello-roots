<article itemscope itemtype="http://schema.org/BlogPosting" class="excerpt excerpt-<?php echo get_post_type(); ?>">
	<header class="excerp__header">
		<h2>
			<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
				<?php the_title(); ?>
			</a>
		</h2>
	</header>
	<div class="excerpt-content">
		<?php the_excerpt(); ?>
	</div>
	<footer class="excerpt-footer">
		<p>
			<?php
			// translators: published at %1$1s and by %2$2s
			printf( __( 'published at %1$1s by %2$2s', 'sht' ), get_the_date(), '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>' );
			?>
		</p>
	</footer>
</article>
