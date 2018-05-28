<article class="page-section page-section--content">
	<header class="content-section content-section--title">
		<h1>
			<?php
			if ( is_404() ) {
				echo __( '404 error', 'sht' );
			} else {
				the_title();
			}
			?>
		</h1>
	</header>

	<div class="content-section post-content">
		<?php
		if ( is_404() ) {
			echo '<p><b>' . __( '404 - page not found.', 'sht' ) . '</b></p>';
			echo '<p>' . __( 'Die Seite konnte nicht gefunden werden.', 'sht' ) . '</p>';
		} else {
			the_content();
		}
		?>
	</div>
</article>
