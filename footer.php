<?php
	use SayHello\Theme\Package\NavWalker;

	do_action('sht_before_footer');
?>
<section class="page-section" id="footer">
	<footer class="footer" role="contentinfo">
		<?php
			wp_nav_menu(
				[
					'theme_location' => 'footer',
					'container'      => '',
					'menu_id'        => 'footer-menu',
					'menu_class'     => 'footer__menu menu menu--footer',
					'walker'         => new NavWalker(),
				]
			);
			?>
	</footer>
</section>
<?php wp_footer(); ?>
</body>
</html>
