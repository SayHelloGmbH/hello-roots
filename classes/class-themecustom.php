<?php

namespace HelloTheme;

class ThemeCustom {

	public function __construct() {

	}

	public function run() {
		add_action( 'after_setup_theme', [ $this, 'register_nav' ] );

		// Third party plugin support
		add_filter( 'hellolog_types', [ $this, 'register_error_log' ] );
	}

	public function register_nav() {
		register_nav_menus( [
			'primary' => __( 'Primary Menu', 'sha' ),
			'footer'  => __( 'Footer Menu', 'sha' ),
		] );
	}

	public function register_error_log( $types ) {

		$types['error'] = __( 'Error', 'sha' );

		return $types;
	}
}
