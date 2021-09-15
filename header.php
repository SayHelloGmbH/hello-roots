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

		<?php do_action('sht_after_body_open'); ?>

		<div class="c-masthead__inner">
			<h1 class="c-masthead__title">
				<a class="c-masthead__titlelink" href="<?php echo get_home_url(); ?>"><?php echo get_bloginfo('name'); ?></a>
			</h1>

			<?php
			get_template_part('partials/navigation/primary');
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
