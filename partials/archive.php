<div class="page-section page-section--content">
	<div class="content-section content-section--title">
		<?php the_archive_title( '<h1>', '</h1>' ); ?>
	</div>
	<div class="content-section">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {

				the_post();
				get_template_part( 'partials/excerpt', get_post_type() );
			}
		}
		?>
	</div>
</div>
<?php
$paginate = paginate_links();
if ( '' != $paginate ) {
	echo '<div class="content-section content-section--pagination pagination">';
	echo "<p class='pagination__container'>$paginate</p>";
	echo '</div>';
}
