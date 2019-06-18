<article class="page-section page-section--content" id="content" role="main">
	<?php do_action('sht_before_content'); ?>
	<header class="content-section content-section--title">
		<h1><?php the_title(); ?></h1>
	</header>
	<div class="content-section post-content c-wpblocks">
		<?php the_content(); ?>
	</div>
	<?php do_action('sht_after_content'); ?>
</article>
