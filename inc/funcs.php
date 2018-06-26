<?php

// Menu output mods
class ShtWalker extends Walker_Nav_Menu {

	public $wp_classes = '';

	public function __construct() {
		// wp classes https://developer.wordpress.org/reference/functions/wp_nav_menu/
		// set the wp class to a class you'd like or false
		$this->wp_classes = [
			'menu-item'                 => 'navigation__item item',
			'menu-item-has-children'    => 'item--has-children',
			'menu-item-object-category' => false,
			'menu-item-object-{object}' => false,
			'menu-item-object-category' => false,
			'menu-item-object-tag'      => false,
			'menu-item-object-page'     => false,
			'menu-item-object-{custom}' => false,
			'menu-item-type-{type}'     => false,
			'menu-item-type-post_type'  => false,
			'menu-item-type-taxonomy'   => false,
			'current-menu-item'         => 'item--active',
			'current-menu-parent'       => 'item--parent',
			'current-{object}-parent'   => false,
			'current-{type}-parent'     => false,
			'current-menu-ancestor'     => 'item--ancestor',
			'current-{object}-ancestor' => false,
			'current-{type}-ancestor'   => false,
			'menu-item-home'            => false,
			'page_item'                 => 'navigation__item item',
			'page_item_has_children'    => 'item--has-children',
			'page-item-{ID}'            => false,
			'current_page_item'         => 'item--active',
			'current_page_parent'       => 'item--parent',
			'current_page_ancestor'     => 'item--ancestor',
		];
	}

	function start_el( &$output, $item, $depth, $args ) {

		global $wp_query;
		//global $this->wp_classes;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		// get wp classes
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = [];

		// modify wp_classes for this item
		$wp_classes = [];
		foreach ( $this->wp_classes as $key => $class ) {

			// check if this $key has value in curly braces
			preg_match_all( '/{(.*?)}/', $key, $matches );

			switch ( $matches[1][0] ) {
				case 'object':
					$value = $item->object;
					break;
				case 'custom':
					$value = $item->custom;
					break;
				case 'type':
					$value = $item->type;
					break;
				case 'ID':
					$value = $item->ID;
					break;
			}

			// if has value in curly braces
			if ( ! empty( $matches[1] ) ) {

				// if $item prop matches matches[1][0] is not empty, push the new key to $wp_classes
				if ( ! empty( $value ) ) {
					$new_key                = str_replace( '{' . $matches[1][0] . '}', $value, $key );
					$wp_classes[ $new_key ] = $class;
				}
			} else {
				$wp_classes[ $key ] = $class;
			}
		}

		foreach ( $wp_classes as $key => $class ) {

			// if class is not false, check if class is in $classes array, then add specified class
			if ( $class && in_array( $key, $classes ) && ! in_array( $class, $class_names ) ) {
				$class_names[] = $class;
			}
		}

		// add item id class
		// $class_names[] = 'item--id-' . $item->ID;

		// add class for depth
		$class_names[] = 'item--depth-' . $depth;

		// get custom classes, add them to $class_names
		$custom_classes = get_post_meta( $item->ID, '_menu_item_classes' );
		foreach ( $custom_classes[0] as $key => $value ) {
			$class_names[] = $value;
		}

		// generate class string for output
		$class_names = ' class="' . esc_attr( implode( ' ', $class_names ) ) . '"';
		$output     .= $indent . '<li ' . $class_names . '>';

		// define attributes
		$permalink_classes   = [];
		$permalink_classes[] = 'item__permalink';
		$attributes         .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes         .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes         .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes         .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		$item_output  = $args->before;
		$item_output .= '<a class="' . implode( ' ', $permalink_classes ) . '" ' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $args->link_after;
		$item_output .= '</a>';

		// if the item has children add the sub-toggle after closing the anchor tag
		if ( $args->has_children ) {
			$item_output .= '<span class="item__sub-toggle" data-toggle="+ navigation__sub"></span>';
		}

		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function start_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$depth++;
		$output .= "\n$indent<ul class=\"navigation__sub sub--depth-$depth\">\n";
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}


}
