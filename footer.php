<?php do_action( 'sht_before_footer' ); ?>
<section class="page-section" id="footer">
	<footer class="footer" role="contentinfo">
		<?php
		wp_nav_menu( [
			'theme_location'  => 'footer',
			'container'       => 'ul',
			'container_id'    => 'footer-menu',
			'container_class' => 'footer__menu navigation navigation--primary',
			'walker'          => new \HelloTheme\ShtWalker( 'navigation' ),
		] );
		?>
	</footer>
</section>
<?php wp_footer(); ?>
</body>
</html>
