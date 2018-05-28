<?php
/**
 * Start of the Theme
 * Loading Partials singular template
 */

get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'partials/singular', get_post_type() );
	}
} else {
	get_template_part( 'partials/singular', 'none' );
}
get_footer();

