<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with menus and site navigation
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Navigation
{

	private $menus;

	public function __construct()
	{
		$this->menus = [
			'primary' => _x('Primary', 'Menu navigation label', 'sha'),
			'mobile' => _x('Mobile', 'Menu navigation label', 'sha'),
		];
	}

	public function run()
	{
		add_filter('wp_nav_menu_args', [$this, 'navMenuArgs'], 1, 1);
		add_filter('nav_menu_css_class', [$this, 'menuItemClasses'], 10, 3);
		add_filter('nav_menu_link_attributes', [$this, 'menuLinkAttributes']);

		if (count($this->menus)) {
			add_action('after_setup_theme', [$this, 'themeSupport']);
		}
	}

	public function themeSupport()
	{
		add_theme_support('menu');
		register_nav_menus($this->menus);
	}

	public function navMenuArgs($args)
	{
		$args['fallback_cb'] = false;
		$args['menu_class'] = 'c-menu__entries c-menu__entries--'.$args['theme_location'];
		return $args;
	}

	public function menuItemClasses($classes, $item, $args)
	{
		$classes[] = 'c-menu__entry c-menu__entry--'.$args->theme_location;
		if ($item->current) {
			$classes[] = 'c-menu__entry--current';
		}
		if ($item->current_item_ancestor) {
			$classes[] = 'c-menu__entry--current_item_ancestor';
		}
		if ($item->current_item_parent) {
			$classes[] = 'c-menu__entry--current_item_parent';
		}
		return $classes;
	}

	public function menuLinkAttributes($atts)
	{
		if (!isset($atts['class'])) {
			$atts['class'] = '';
		}
		$atts['class'] = (!empty($atts['class']) ? ' ': '').'c-menu__entrylink';
		return $atts;
	}
}
