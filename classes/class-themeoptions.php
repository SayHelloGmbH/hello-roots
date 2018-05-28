<?php

namespace HelloTheme;

/**
 * Provides a Class for Admin Settings
 */
class ThemeOptions {

	public $main_slug = '';
	public $general_slug = '';

	public function __construct() {
		$this->main_slug    = sht_theme()->pfx . '-settings';
		$this->general_slug = $this->main_slug . '-general';
	}

	public function run() {
		add_action( 'acf/init', [ $this, 'page_main' ], 1 );
		add_action( 'acf/init', [ $this, 'page_general' ] );
		add_action( 'acf/init', [ $this, 'options_general' ] );
	}

	public function page_main() {
		acf_add_options_page( [
			'menu_title' => __( 'Theme Settings', 'sha' ),
			'menu_slug'  => $this->main_slug,
			'position'   => 30,
		] );
	}

	public function page_general() {
		acf_add_options_sub_page( [
			'page_title'  => __( 'General Settings', 'sha' ),
			'menu_title'  => __( 'General', 'sha' ),
			'menu_slug'   => $this->general_slug,
			'parent_slug' => $this->main_slug,
			'capability'  => 'edit_theme_options',
		] );
	}

	public function options_general() {

		$pfx = sht_theme()->pfx;

		/**
		 * Contact
		 */

		acf_add_local_field_group( [
			'key'      => "$pfx-contact-group",
			'title'    => __( 'Kontakt', 'sha' ),
			'fields'   => [
				[
					'key'   => "field_$pfx-contact-tel",
					'name'  => "$pfx-contact-tel",
					'label' => __( 'Telefon', 'sha' ),
					'type'  => 'text',
				],
				[
					'key'   => "field_$pfx-contact-fax",
					'name'  => "$pfx-contact-fax",
					'label' => __( 'Fax', 'sha' ),
					'type'  => 'text',
				],
				[
					'key'   => "field_$pfx-contact-email",
					'name'  => "$pfx-contact-email",
					'label' => __( 'Email', 'sha' ),
					'type'  => 'email',
				],
				[
					'key'   => "field_$pfx-contact-name",
					'name'  => "$pfx-contact-name",
					'label' => __( 'Name', 'sha' ),
					'type'  => 'text',
				],
				[
					'key'     => "field_$pfx-contact-street",
					'name'    => "$pfx-contact-street",
					'label'   => __( 'Strasse', 'sha' ),
					'type'    => 'text',
					'wrapper' => [
						'width' => 70,
					],
				],
				[
					'key'     => "field_$pfx-contact-number",
					'name'    => "$pfx-contact-number",
					'label'   => __( 'Nummer', 'sha' ),
					'type'    => 'text',
					'wrapper' => [
						'width' => 30,
					],
				],
				[
					'key'     => "field_$pfx-contact-zip",
					'name'    => "$pfx-contact-zip",
					'label'   => __( 'PLZ', 'sha' ),
					'type'    => 'text',
					'wrapper' => [
						'width' => 30,
					],
				],
				[
					'key'     => "field_$pfx-contact-city",
					'name'    => "$pfx-contact-city",
					'label'   => __( 'Ort', 'sha' ),
					'type'    => 'text',
					'wrapper' => [
						'width' => 70,
					],
				],
				[
					'key'     => "field_$pfx-contact-state",
					'name'    => "$pfx-contact-state",
					'label'   => __( 'Kanton', 'sha' ),
					'type'    => 'text',
					'wrapper' => [
						'width' => 50,
					],
				],
				[
					'key'     => "field_$pfx-contact-country",
					'name'    => "$pfx-contact-country",
					'label'   => __( 'Land', 'sha' ),
					'type'    => 'text',
					'wrapper' => [
						'width' => 50,
					],
				],
			],
			'location' => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => $this->general_slug,
					],
				],
			],
		] );

		/**
		 * Analytics
		 */

		acf_add_local_field_group( [
			'key'        => "$pfx-analytics-group",
			'title'      => __( 'Analytics Tracking', 'sha' ),
			'fields'     => [
				[
					'key'   => "field_$pfx-analytics-track-id",
					'name'  => "$pfx-analytics-track-id",
					'label' => __( 'Google Analytics / Tag Manger ID', 'sha' ),
					'type'  => 'text',
				],
			],
			'location'   => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => $this->general_slug,
					],
				],
			],
			'menu_order' => 50,
		] );
	}
}
