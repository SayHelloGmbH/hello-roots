<?php

/**
 *  Output comments wrapper if it's a post, or if comments are open,
 * or if there's a comment number – and check for password.
 * */
if (( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required()) {
	?>
	<div class="c-comments">
		<?php comments_template(); ?>
	</div>
	<?php
}
