<?php
/**
 * Custom Nav Menu Walker
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

class ClassiPress_Walker_Nav_Menu extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu cp-dropdown\" role=\"menu\">\n";
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
        $item   = $data_object;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if ( in_array( 'menu-item-has-children', $classes, true ) ) {
            $classes[] = 'cp-has-dropdown';
        }

        $class_names = implode( ' ', array_filter( array_map( 'esc_attr', $classes ) ) );
        $id          = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id          = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . ' class="' . $class_names . '">';

        $atts          = [];
        $atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target']= ! empty( $item->target ) ? $item->target : '';
        $atts['rel']   = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']  = ! empty( $item->url ) ? $item->url : '';
        $atts['class'] = 'menu-link';

        if ( $item->current || $item->current_item_ancestor ) {
            $atts['aria-current'] = 'page';
        }

        $atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output  = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( $args->link_before ?? '' ) . $title . ( $args->link_after ?? '' );

        if ( in_array( 'menu-item-has-children', $classes, true ) && $depth === 0 ) {
            $item_output .= '<span class="cp-dropdown-arrow" aria-hidden="true">▾</span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
