<?php do_action( 'sht_before_footer' ); ?>
<section class="page-section" id="footer">
	<footer class="footer" role="contentinfo">
		<?php
		wp_nav_menu(
			[
				'theme_location' => 'footer',
				'container'      => '',
				'menu_id'        => 'footer-menu',
				'menu_class'     => 'footer__menu navigation navigation--footer',
			]
		);
		?>
	</footer>
</section>
<?php wp_footer(); ?>
</body>
</html>
