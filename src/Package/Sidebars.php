<?php

namespace SayHello\Theme\Package;

/**
 * Sidebar stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Sidebars
{


	private $sidebars;

	public function __construct()
	{
		$this->sidebars = [
			[
				'name'          => __('Main sidebar', 'sht'),
				'id'            => 'sidebar_main',
				'description'   => __('Widget area', 'sht'),
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
			add_action('after_setup_theme', [ $this, 'themeSupport' ]);
			add_action('widgets_init', [ $this, 'register' ]);
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
