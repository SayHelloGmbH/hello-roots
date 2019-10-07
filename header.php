<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class('no-js'); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<section class="c-page__section" id="header">
	<header class="c-page__header" role="banner">

		<h1 class="c-site__title">
			<a class="c-site__titlelink" href="<?php echo get_home_url();?>"><?php echo get_bloginfo('name');?></a>
		</h1>

		<?php
		wp_nav_menu(
			[
				'theme_location' => 'primary',
				'container'      => 'nav',
				'container_class' => 'c-menu c-menu--primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'c-menu c-menu--primary',
			]
		);
		?>

		<button class="c-menutoggler" aria-controls="primary-menu" aria-expanded="false">
			<span class="c-menutoggler__line"></span>
			<span class="c-menutoggler__line"></span>
			<span class="c-menutoggler__line"></span>
		</button>

	</header>
</section>
