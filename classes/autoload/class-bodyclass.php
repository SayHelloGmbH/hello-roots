<?php

namespace SayHello\autoload;

class Bodyclass {

	public function __construct() {

		add_action( 'init', [ $this, 'add_body_class' ], 30 );
	}

	public function run() {
		add_action( 'init', [ $this, 'add_body_class' ], 30 );
	}

	public function add_body_class() {
		add_filter( 'body_class', [ $this, 'body_classes' ], 1 );
	}


	/**
	 * Provides a function that adds custom
	 * css Classes to Website
	 *
	 * @param  array $classes default is empty
	 *
	 * @return array Containing all necessary Classes
	 */
	public function body_classes( $classes ) {

		$classes = [];

		if ( is_404() ) {
			$classes[] = 'page-404';
		}
		if ( is_search() ) {
			$classes[] = 'search';
		}

		if ( is_front_page() ) {
			$classes[] = 'page-home';
		}

		if ( is_home() || is_archive() ) {

			if ( is_home() || is_post_type_archive() ) {

				if ( is_home() ) {
					$pt = 'post';
				} else {
					$pt = get_query_var( 'post_type', 1 );
				}
				$classes[] = 'archive';
				$classes[] = 'archive-' . $pt;

			} else {

				if ( is_author() ) {
					$classes[] = 'archive';
					$classes[] = 'archive-author';
					$classes[] = 'author';
				} else {
					$classes[] = 'taxonomy';
					$classes[] = 'taxonomy-' . get_term( get_queried_object_id() )->taxonomy;
				}
			}
		}

		if ( is_singular() ) {
			$classes[] = 'single';
			$classes[] = 'single-' . get_post_type();
		}

		if ( is_paged() ) {
			$classes[] = 'paged-' . get_query_var( 'paged' );
		} else {
			$classes[] = 'not-paged';
		}

		if ( is_user_logged_in() ) {
			$classes[] = 'logged-in';
		}

		if ( is_admin_bar_showing() ) {
			$classes[] = 'admin-bar';
		}

		return $classes;
	}
}
