<?php

namespace SayHello\Theme\Package;

/**
 * Theme Options
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */

class ThemeOptions
{

	public $main_slug = '';
	public $general_slug = '';

	public function __construct()
	{
		$this->main_slug    = sht_theme()->prefix . '-settings';
		$this->general_slug = $this->main_slug . '-general';
	}

	public function run()
	{
		add_action('acf/init', [ $this, 'pageMain' ], 1);
		add_action('acf/init', [ $this, 'pageGeneral' ]);
		add_action('acf/init', [ $this, 'optionsGeneral' ]);
	}

	public function pageMain()
	{

		if (function_exists('acf_add_options_page')) {
			acf_add_options_page(
				[
					'menu_title' => __('Theme Settings', 'sha'),
					'menu_slug'  => $this->main_slug,
					'position'   => 30,
				]
			);
		}
	}

	public function pageGeneral()
	{
		if (function_exists('acf_add_options_sub_page')) {
			acf_add_options_sub_page(
				[
					'page_title'  => __('General Settings', 'sha'),
					'menu_title'  => __('General', 'sha'),
					'menu_slug'   => $this->general_slug,
					'parent_slug' => $this->main_slug,
					'capability'  => 'edit_theme_options',
				]
			);
		}
	}

	public function optionsGeneral()
	{

		/**
		 * Contact
		 */

		if (function_exists('acf_add_local_field_group')) {
			$prefix = sht_theme()->prefix;

			acf_add_local_field_group(
				[
					'key'      => "$prefix-contact-group",
					'title'    => __('Kontakt', 'sha'),
					'fields'   => [
						[
							'key'   => "field_$prefix-contact-tel",
							'name'  => "$prefix-contact-tel",
							'label' => __('Telefon', 'sha'),
							'type'  => 'text',
						],
						[
							'key'   => "field_$prefix-contact-fax",
							'name'  => "$prefix-contact-fax",
							'label' => __('Fax', 'sha'),
							'type'  => 'text',
						],
						[
							'key'   => "field_$prefix-contact-email",
							'name'  => "$prefix-contact-email",
							'label' => __('Email', 'sha'),
							'type'  => 'email',
						],
						[
							'key'   => "field_$prefix-contact-name",
							'name'  => "$prefix-contact-name",
							'label' => __('Name', 'sha'),
							'type'  => 'text',
						],
						[
							'key'     => "field_$prefix-contact-street",
							'name'    => "$prefix-contact-street",
							'label'   => __('Strasse', 'sha'),
							'type'    => 'text',
							'wrapper' => [
								'width' => 70,
							],
						],
						[
							'key'     => "field_$prefix-contact-number",
							'name'    => "$prefix-contact-number",
							'label'   => __('Nummer', 'sha'),
							'type'    => 'text',
							'wrapper' => [
								'width' => 30,
							],
						],
						[
							'key'     => "field_$prefix-contact-zip",
							'name'    => "$prefix-contact-zip",
							'label'   => __('PLZ', 'sha'),
							'type'    => 'text',
							'wrapper' => [
								'width' => 30,
							],
						],
						[
							'key'     => "field_$prefix-contact-city",
							'name'    => "$prefix-contact-city",
							'label'   => __('Ort', 'sha'),
							'type'    => 'text',
							'wrapper' => [
								'width' => 70,
							],
						],
						[
							'key'     => "field_$prefix-contact-state",
							'name'    => "$prefix-contact-state",
							'label'   => __('Kanton', 'sha'),
							'type'    => 'text',
							'wrapper' => [
								'width' => 50,
							],
						],
						[
							'key'     => "field_$prefix-contact-country",
							'name'    => "$prefix-contact-country",
							'label'   => __('Land', 'sha'),
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
				]
			);

			/**
			 * Analytics
			 */

			acf_add_local_field_group(
				[
					'key'        => "$prefix-analytics-group",
					'title'      => __('Analytics Tracking', 'sha'),
					'fields'     => [
						[
							'key'   => "field_$prefix-analytics-track-id",
							'name'  => "$prefix-analytics-track-id",
							'label' => __('Google Analytics / Tag Manger ID', 'sha'),
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
				]
			);
		}
	}

	/**
	 * return theme options with schema itemprops
	 *
	 * @param $args array of options to display. you can set just the option name or define an option array like $itemprops
	 * @param $return set to false to return array of data, if true echo html
	 * @param $container set to true to add container with itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"
	 * @param $base_class set to true to use classes. you can specify your BEM class base as string
	 *
	 * @example return all options as array sht_theme()->Package->ThemeOptions->get( );
	 * @example return tel option as array sht_theme()->Package->ThemeOptions->get( [ 'tel' ] );
	 * @example echo all options with container sht_theme()->ThemeOptions->get( [], true, true );
	 */

	public function get($args = [], $return = false, $container = false, $base_class = false)
	{

		// if $args is string, set string to first item of $args
		if ('string' == gettype($args)) {
			$args = [ $args ];
		}

		// defualt $base_class if $base_class = true
		if ($base_class && 'string' != gettype($base_class)) {
			$base_class = 'address';
		}

		// if $args is not an array return
		if (! is_array($args)) {
			return;
		}

		// default setup for themeoptions
		$itemprops = [
			'tel'     => [
				'prop' => 'telephone',
				'elem' => 'a',
				'attr' => [ 'href="tel:{value}"' ],
			],
			'fax'     => [
				'prop' => 'faxNumber',
				'elem' => 'a',
				'attr' => [ 'href="fax:{value}"' ],
			],
			'email'   => [
				'prop' => 'email',
				'elem' => 'a',
				'attr' => [ 'href="mailto:{value}"' ],
			],
			'name'    => [
				'prop' => 'name',
				'elem' => 'span',
				'attr' => false,
			],
			// street includes street number
			'street'  => [
				'prop' => 'streetAddress',
				'elem' => 'span',
				'attr' => false,
			],
			'zip'     => [
				'prop' => 'postalCode',
				'elem' => 'span',
				'attr' => false,
			],
			'city'    => [
				'prop' => 'addressLocality',
				'elem' => 'span',
				'attr' => false,
			],
			'state'   => [
				'prop' => 'addressRegion',
				'elem' => 'span',
				'attr' => false,
			],
			'country' => [
				'prop' => 'addressCountry',
				'elem' => 'span',
				'attr' => false,
			],
		];

		$output    = [];
		$field_key = 'field_' . sht_theme()->prefix . '-contact-';

		foreach ($itemprops as $key => $itemprop) {
			// add all options or just the one in $args
			if (empty($args) || in_array($key, $args)) {
				$prop  = isset($args[ $key ][ 'prop' ]) ? $args[ $key ][ 'prop' ] : $itemprops[ $key ][ 'prop' ];
				$elem  = isset($args[ $key ][ 'elem' ]) ? $args[ $key ][ 'elem' ] : $itemprops[ $key ][ 'elem' ];
				$attr  = isset($args[ $key ][ 'attr' ]) ? $args[ $key ][ 'attr' ] : $itemprops[ $key ][ 'attr' ];
				$value = (! empty(get_field($field_key . $key, 'option'))) ? get_field($field_key . $key, 'option') : false;

				// if is street add number if exists
				if ('street' == $key) {
					$value = (! empty(get_field($field_key . 'number', 'option'))) ? $value . ' ' . get_field($field_key . 'number', 'option') : $value;
				}

				// if $attr is string, set string to first item of $attr
				if ('string' == gettype($attr)) {
					$attr = [ $attr ];
				}

				// // if classes are enabled, check $string and generate BEM class
				if ($base_class) {
					// generate the bem class for the current item
					$bem_class = $base_class . '__' . $key;

					if (is_array($attr)) {
						foreach ($attr as $name => $string) {
							//check if $string contains 'class'
							if (strpos($string, 'class') !== false) {
								preg_match_all('/"(.*?)"/', $string, $matches);

								// get value in class=""
								if (! empty($matches[ 1 ])) {
									unset($attr[ $name ]);
									$bem_class .= ' ' . $matches[ 1 ][ 0 ];
								}

								// remove class attribute in array
								unset($matches);
							}
						}

						// push new class attribute to array
						array_push($attr, 'class="' . $bem_class . '"');
					} else {
						// set class attribute in array
						$attr = [ 'class="' . $bem_class . '"' ];
					}
				}

				if (! empty($value) && ! empty($elem)) {
					// check if this items of $attr has value in curly braces
					if (is_array($attr)) {
						foreach ($attr as $name => $string) {
							//var_dump( $value );
							preg_match_all('/{(.*?)}/', $string, $matches);

							// if has value in curly braces
							if (! empty($matches[ 1 ])) {
								// what to do for matches matching
								switch ($matches[ 1 ][ 0 ]) {
									case 'value':
										$replace = str_replace('{' . $matches[ 1 ][ 0 ] . '}', $value, $attr[ $name ]);
										//var_dump( $replace );
										break;
								}

								// replace value from attr item
								if (! empty($replace)) {
									$attr[ $name ] = $replace;
								}
							}
						}
					}

					$html = '<' . $elem . ' itemprop="' . $prop . '" ';
					if (! empty($attr)) {
						$html .= implode(' ', $attr) . ' ';
					}
					$html .= '>' . $value . '</' . $elem . '>';

					$output[ $key ] = [
						'prop'  => ($prop) ? $prop : $itemprop[ 'prop' ],
						'elem'  => ($elem) ? $elem : $itemprop[ 'elem' ],
						'attr'  => ($attr) ? $attr : $itemprop[ 'attr' ],
						'value' => $value,
						'html'  => $html,
					];
				}
			}
		}

		//if $return is false return data
		if (! $return) {
			if (1 == sizeof($output)) {
				// returns the first elemen of array regardless of key
				return reset($output);
			} else {
				return $output;
			}
		}

		switch ($return) {
			default:
				// if $container is set to true, start with wrapper

				// generate class string
				if ($base_class) {
					$class = 'class="' . $base_class . '"';
				} else {
					$class = '';
				}

				// QUESTION: this container is hardcoded. should it be customizable?
				$html_output = ($container) ? '<address ' . $class . ' itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">' : '';

				foreach ($output as $key => $value) {
					$html_output .= $value[ 'html' ];
				}

				// if $container is set to true, end with wrapper
				if ($container) {
					$html_output .= '</address>';
				}

				echo $html_output;

				break;
		}
	}
}
