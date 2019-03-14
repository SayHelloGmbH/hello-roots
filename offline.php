<?php
get_header();
?>
	<article class="page-section page-section--content">
		<header class="content-section content-section--title">
			<h1><?php echo __('Offliner', 'sht'); ?></h1>
		</header>
		<div class="content-section post-content">
			<?php
			echo '<p><b>' . __("You're offline.", 'sht') . '</b></p>';
			?>
		</div>
	</article>
<?php
get_footer();
