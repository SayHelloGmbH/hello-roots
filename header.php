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
<?php echo sht_get_lazysizes_img( 334, 'full' ); ?>
<figure class='lazyimage' style='background-color: transparent'>
	<img class='lazyimage__preview' src='http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-30x19-q30.jpg'/>
	<img width='4912' height='3264' alt='' class='lazyimage__image lazyimage__image--lazyload' data-sizes='auto' src='http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-30x19-q30.jpg' data-srcset='http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang.jpg 4912w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-2000x1328.jpg 2000w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-1200x797.jpg 1200w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-640x425.jpg 640w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-320x212.jpg 320w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-160x106.jpg 160w'/>
	<noscript>
		<img width='4912' height='3264' alt='' src='http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang.jpg' srcset='http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang.jpg 4912w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-2000x1328.jpg 2000w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-1200x797.jpg 1200w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-640x425.jpg 640w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-320x212.jpg 320w, http://shdev.hello/wp-content/uploads/2018/03/sonnenuntergang-160x106.jpg 160w'/>
	</noscript>
</figure>
