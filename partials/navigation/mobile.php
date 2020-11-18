<nav class="c-nav c-nav--mobile" id="mobile-menu" aria-hidden="true" data-root-style="is--mobilemenu">
	<?php
	wp_nav_menu(
		[
			'theme_location' => 'mobile',
			'container' => false,
			'menu_class' => 'c-menu c-menu--mobile',
		]
	);
	?>
</nav>
