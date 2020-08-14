<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class('no-js'); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<section class="c-masthead" role="banner">

	<div class="c-masthead__inner">
		<h1 class="c-masthead__title">
			<a class="c-masthead__titlelink" href="<?php echo get_home_url();?>"><?php echo get_bloginfo('name');?></a>
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

		<div class="c-masthead__toggler">
			<?php
			get_template_part('partials/navigation/menutoggler', null, [
				'target_id' => 'mobile-menu'
			]);
			?>
		</div>
	</div>

</section>
