<?php

namespace SayHello\Theme\Package;

class CustomPages {


	public $prefix        = 'cp';
	public $special_pages = '';

	public function __construct() {
		$this->special_pages = [
			'selfservice' => __( 'Self-Service', 'sha' ),
			'vzughome'    => __( 'V-ZUG-Home', 'sha' ),
			'contact'     => __( 'Kontakt', 'sha' ),
			'search'      => __( 'Search', 'sha' ),
			'404'         => __( '404 Error', 'sha' ),
		];
	}

	public function run() {

		//Adds an options Page (ACF) if there are CPTs that have an Archive.
		add_action( 'init', [ $this, 'optionsPage' ], 35 );
		//Adds some JS to the footer for a proper Archivepage Styling
		add_action( 'admin_footer', [ $this, 'footerJs' ] );
		//Update slug on save
		add_action( 'save_post', [ $this, 'changePageslugToCptslug' ] );
		add_action( 'acf/save_post', [ $this, 'changePageslugToCptslugOnacf' ], 1 );
		add_filter( 'page_link', [ $this, 'archivePermalink' ], 10, 2 );

		// Archive Title
		add_filter( 'get_the_archive_title', [ $this, 'changeArchiveTitle' ] );

		// Body Class
		add_filter( 'body_class', [ $this, 'bodyClasses' ] );
	}

	public function optionsPage() {

		if ( function_exists( 'acf_add_local_field' ) && function_exists( 'acf_add_options_sub_page' ) && function_exists( 'acf_add_local_field_group' ) ) {
			$options_slug  = $this->prefix . '-settings';
			$options_title = __( 'Custom Pages', 'sht' );

			acf_add_options_sub_page(
				[
					'page_title'  => $options_title,
					'menu_title'  => $options_title,
					'menu_slug'   => $options_slug,
					'parent_slug' => 'options-general.php',
					'capability'  => 'administrator',
				]
			);

			acf_add_local_field_group(
				[
					'key'      => $this->prefix . '-cp-group',
					'title'    => __( 'Post Types', 'sha' ),
					'location' => [
						[
							[
								'param'    => 'options_page',
								'operator' => '==',
								'value'    => $options_slug,
							],
						],
					],
					'fields'   => [
						[
							'key'     => $this->prefix . '-cp-group-message',
							'type'    => 'message',
							'message' => __( 'Hier können den verschiedenen Post-Types Seiten zugeordnet werden, die dann als Archive fungieren.', 'sha' ) . '<br><b>' . __( 'Achtung: Nur mit Vorsicht verändern!', 'sha' ) . '</b>',
						],
					],
				]
			);

			$possible_pages = [
				0 => 'select..',
			];

			$pages = get_pages(
				[
					'numberposts' => -1,
				]
			);

			foreach ( $pages as $page ) {
				   $pretitle = '';
				   $parents  = get_post_ancestors( $page );
				foreach ( $parents as $parent ) {
					$pretitle .= '- ';
				}

				   $possible_pages[ $page->ID ] = $pretitle . get_the_title( $page->ID );
			}

			$post_types = $this->getPosttypeItems();

			if ( ! empty( $post_types ) ) {
				if ( function_exists( 'acf_add_local_field' ) ) {
					acf_add_local_field(
						[
							'key'    => 'field_page_for_x_title',
							'name'   => 'page_for_x_title',
							'label'  => __( 'Post Type Archives', 'sha' ),
							'type'   => 'tab',
							'parent' => $this->prefix . '-cp-group',
						]
					);
				}

				foreach ( $post_types as $pt => $name ) {
					acf_add_local_field(
						[
							'key'     => 'field_page_for_' . $pt,
							'name'    => 'page_for_' . $pt,
							'label'   => $name . ' Archiv',
							'type'    => 'select',
							'parent'  => $this->prefix . '-cp-group',
							'choices' => $possible_pages,
						]
					);
				}
			} else {
				acf_add_local_field(
					[
						'key'     => $this->prefix . '-cp-group-message-none',
						'type'    => 'message',
						'message' => __( 'Es existieren keine custom Post-Types bein denen has_archive und publicly_queryable auf true gesetzt sind.', 'sha' ),
						'parent'  => $this->prefix . '-cp-group',
					]
				);
			} // End if().

			$special_pages = $this->getSpecialItems();

			if ( empty( $special_pages ) ) {
				return;
			}

			acf_add_local_field(
				[
					'key'    => 'field_page_for_special_title',
					'name'   => 'page_for_special_title',
					'label'  => __( 'Special Pages', 'sha' ),
					'type'   => 'tab',
					'parent' => $this->prefix . '-cp-group',
				]
			);

			foreach ( $special_pages as $key => $name ) {
				acf_add_local_field(
					[
						'key'     => "field_page_for_$key",
						'name'    => "page_for_$key",
						'label'   => sprintf( _x( 'Page for "%s"', 'Page for "Search"', 'sha' ), $name ),
						'type'    => 'select',
						'parent'  => $this->prefix . '-cp-group',
						'choices' => $possible_pages,
					]
				);
			}
		}
	}

	public function footerJs() {

		if ( function_exists( 'get_field' ) ) {
			$screen = get_current_screen();

			if ( 'page' == $screen->id ) {
				$page_pt = false;
				foreach ( $this->getPosttypeItems() as $pt => $name ) {
					$field = get_field( "page_for_$pt", 'options' );
					if ( $field && $field == $_GET['post'] ) {
						$page_pt = $name;
					}
				}

				if ( ! $page_pt ) {
					return;
				}

				// translators: Du bearbeitest gerade die Seite, die als Übersicht über "Posts" definiert wurde. Der Permalink wird deshalb automatisch überschrieben und die Inhalte können je nach Verwendung im Theme abweichen.
				$infotext = sprintf( __( 'Du bearbeitest gerade die Seite, die als Übersicht über "%s" definiert wurde. Der Permalink wird deshalb automatisch überschrieben und die Inhalte können je nach Verwendung im Theme abweichen.', 'sha' ), "<b>{$page_pt}</b>" );

				echo '<script id="sayhello_CustomPage">';
				echo 'jQuery(function($){';
				echo '$("#titlediv").append("<div class=\"notice notice-warning inline\" style=\"margin-top:20px;\"><p>' . addslashes( $infotext ) . '</p></div>");';
				echo '});';
				echo '</script>';
			} elseif ( 'edit-page' == $screen->id ) {
				$items = array_merge( $this->getPosttypeItems(), $this->getSpecialItems() );

				echo '<script id="sayhello_CustomPage">';
				echo "jQuery(function($){\n";

				foreach ( $items as $key => $name ) {
					$page_id = get_field( "page_for_$key", 'options' );
					if ( 'page' == get_post_type( $page_id ) ) {
						// translators: "Posts" Page
						$text = sprintf( __( '"%s" Page', 'sha' ), $name );
						echo "$('tbody#the-list tr#post-$page_id td.title strong').append(' — <span class=\"post-state\">$text</ span>');\n";
					}
				}

				echo '});';
				echo '</script>';
			}
		}
	}

	public function changePageslugToCptslug( $post_id ) {

		if ( ! wp_is_post_revision( $post_id ) ) {
			//remove the hook to prevent from invinite loop
			remove_action( 'save_post', [ $this, 'changePageslugToCptslug' ] );

			$assoc_pt = $this->getPosttypeForArchivePageid( $post_id );
			if ( ! $assoc_pt ) {
				return;
			}

			$assoc_pt_ob = get_post_type_object( $assoc_pt );

			$slug = $assoc_pt_ob->rewrite['slug'] . '-alias-' . $post_id;
			if ( strpos( $slug, '/' ) !== false ) {
				$slug = explode( '/', $slug )[0];
			}

			$this->changeslug( $post_id, $slug );

			// re-hook this function
			add_action( 'save_post', [ $this, 'changePageslugToCptslug' ] );
		}
	}

	public function changePageslugToCptslugOnacf( $post_id ) {

		if ( empty( $_POST['acf'] ) ) {
			return;
		}

		$posttypes = get_post_types(
			[
				'_builtin' => false,
			]
		);

		foreach ( $posttypes as $pt ) {
			if ( isset( $_POST['acf'][ 'page_for_' . $pt ] ) ) {
				$assoc_pt_ob = get_post_type_object( $pt );
				$slug        = $assoc_pt_ob->rewrite['slug'] . '-alias-' . $post_id;
				if ( strpos( $slug, '/' ) !== false ) {
					$slug = explode( '/', $slug )[0];
				}

				$this->changeslug( $_POST['acf'][ 'page_for_' . $pt ], $slug );
			}
		}
	}

	public function archivePermalink( $url, $post_id ) {
		$assoc_pt = $this->getPosttypeForArchivePageid( $post_id );
		if ( ! $assoc_pt ) {
			return $url;
		}

		return get_post_type_archive_link( $assoc_pt );
	}

	/**
	 * Helpers
	 */

	public function changeslug( $post_id, $slug ) {

		$post_with_sameslug = get_page_by_path( $slug );
		if ( ! is_null( $post_with_sameslug ) ) {
			wp_update_post(
				[
					'ID'        => $post_with_sameslug->ID,
					'post_name' => $slug . '-alias',
				]
			);
		}

		// update the post slug
		wp_update_post(
			[
				'ID'        => $post_id,
				'post_name' => $slug,
			]
		);

		if ( ! is_null( $post_with_sameslug ) ) {
			wp_update_post(
				[
					'ID'        => $post_with_sameslug->ID,
					'post_name' => $slug,
				]
			);
		}
	}

	public function getPosttypeItems() {
		$posttypes = get_post_types(
			[
				'_builtin' => false,
			]
		);

		$post_types = [];

		foreach ( $posttypes as $pt ) {
			$post_type = get_post_type_object( $pt );
			if ( $post_type->has_archive && $post_type->publicly_queryable ) {
				$post_types[ $pt ] = $post_type->labels->name;
			}
		}

		return $post_types;
	}

	public function getSpecialItems() {
		return apply_filters( 'sht_special_pages', $this->special_pages );
	}

	public function getPosttypeForArchivePageid( $post_id ) {
		if ( function_exists( 'get_field' ) ) {
			foreach ( array_keys( $this->getPosttypeItems() ) as $key ) {
				$field = get_field( "page_for_$key", 'options' );
				if ( $field && $post_id == $field ) {
					return $key;
				}
			}
		}
		return false;
	}

	public function changeArchiveTitle( $title ) {
		if ( function_exists( 'get_field' ) ) {
			if ( ! is_admin() && is_post_type_archive() ) {
				$post_type  = get_query_var( 'post_type' );
				$assoc_page = get_field( "page_for_{$post_type}", 'options' );

				if ( 'page' == get_post_type( $assoc_page ) ) {
					$title = get_the_title( $assoc_page );
				}
			}
		}

		return $title;
	}

	public function bodyClasses( $classes ) {
		if ( function_exists( 'get_field' ) ) {
			foreach ( array_keys( $this->special_pages ) as $key ) {
				if ( is_singular() && get_field( "page_for_$key", 'option' ) == get_the_id() ) {
					$classes[] = "page-special--$key";
				}
			}
		}

		return $classes;
	}
}
