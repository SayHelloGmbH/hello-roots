<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('c-loop__entry c-loop__entry--' . get_post_type()); ?>>

	<header class="c-loop__entryheader">
		<h2 class="c-loop__entrytitle">
			<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
				<?php the_title(); ?>
			</a>
		</h2>
		<time class="c-loop__entrydate" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
	</header>

	<div class="c-loop__entrycontent">
		<?php the_excerpt(); ?>
	</div>

	<a class="c-loop__entrymore" href="<?php the_permalink(); ?>"><?php _ex('Weiterlesen', 'Excerpt read more link', 'sht') ?></a>

</article>
