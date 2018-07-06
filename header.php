<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<!-- Custom Design and Developement by -->
<!-- Say Hello GmbH - https://sayhello.ch -->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'sht_after_body_open' ); ?>
<section class="page-section" id="header">
	<header class="header" role="banner">
		<?php sht_logo(); ?>
		<button class="header__navtoggler navtoggler js-navtoggler navtoggler--primary" aria-controls="primary-menu" aria-expanded="false">
			<?php
			for ( $i = 1; $i <= 3; $i ++ ) {
				echo "<span class='navtoggler__line navtoggler__line--$i'></span>";
			}
			?>
		</button>
		<?php
		wp_nav_menu( [
			'theme_location' => 'primary',
			'container'      => '',
			'menu_id'        => 'primary-menu',
			'menu_class'     => 'header__menu navigation navigation--primary',
			'walker'         => new \HelloTheme\ShtWalker( 'navigation' ),
		] );
		?>
	</header>
</section>
<?php do_action( 'sht_after_header' ); ?>
