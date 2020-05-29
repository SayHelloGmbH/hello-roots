<?php

namespace SayHello\Theme\PostType;

/**
 * Stuff for Pages
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Page
{

	const POST_TYPE = 'page';
	const PREFIX = 'sht_page';

	public function run()
	{
		add_filter('acf/init', [$this, 'registerFields']);
	}

	public function registerFields()
	{
		if (function_exists('acf_add_local_field_group')) :
			acf_add_local_field_group([
				'key' => self::PREFIX.'_group_options',
				'title' => __('Seitenoptionen', 'sha'),
				'fields' => [[
					'key' => self::PREFIX.'_hide_title',
					'name' => 'hide_title',
					'label' => __('Titel verstecken?', 'sha'),
					'type' => 'true_false',
					'instructions' => __('Wenn der Seitentitel ausgeblendet wird, ist es für die Suchmaschinenoptimierung ratsam, eine Überschrift mit der Ebene H1 in den Inhalt einzufügen.', 'sha'),
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => [
						'width' => '',
						'class' => '',
						'id' => '',
					],
					'message' => '',
					'default_value' => 1,
					'ui' => 1,
					'ui_on_text' => __('Ja', 'sha'),
					'ui_off_text' => __('Nein', 'sha'),
				]
				],
				'location' => [
					[
						[
							'param' => 'post_type',
							'operator' => '==',
							'value' => self::POST_TYPE,
						],
					],
				],
				'menu_order' => 0,
				'position' => 'side',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			]);
		endif;
	}
}
