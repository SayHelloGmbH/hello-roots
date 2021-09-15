<?php

namespace SayHello\Theme\Package;

/**
 * Sidebar stuff
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Sidebars
{

	private $sidebars;

	public function __construct()
	{
		$this->sidebars = [
			[
				'name'          => __('Main sidebar', 'sha'),
				'id'            => 'sidebar_main',
				'description'   => __('Widget area', 'sha'),
				'before_widget' => '<div class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
			],
		];
	}

	public function run()
	{
		if (count($this->sidebars)) {
			add_action('after_setup_theme', [$this, 'themeSupport']);
			add_action('widgets_init', [$this, 'register']);
		}
	}

	public function themeSupport()
	{
		add_theme_support('sidebars');
	}

	public function register()
	{
		foreach ($this->sidebars as $sidebar) {
			register_sidebar($sidebar);
		}
	}
}
