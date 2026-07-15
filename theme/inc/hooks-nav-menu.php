<?php

/**
 * Filters the HTML attributes applied to a menu's list item element.
 *
 * @param  array     $atts
 * @param  WP_Post  $menu_item
 * @param  stdClass $args
 * @param  int       $depth
 * @return array
 */
function wplite_nav_menu_item_attributes(array $atts, WP_Post $menu_item, stdClass $args, int $depth): array {
    $atts['class'] = 'nav-item';
    $atts['id']    = 'nav-item-'. $menu_item->ID;

    if (in_array('menu-item-has-children', $menu_item->classes)) {
      	$atts['class'] .= ' dropdown';
    }

    return $atts;
}
add_filter('nav_menu_item_attributes', 'wplite_nav_menu_item_attributes', 10, 4);

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * @param  array     $atts
 * @param  WP_Post  $menu_item
 * @param  stdClass $args
 * @param  int       $depth
 * @return array
 */
function wplite_nav_menu_link_attributes(array $atts, WP_Post $menu_item, stdClass $args, int $depth): array {
    $atts['class'] = 0 < $depth ? 'dropdown-item' : 'nav-link';

    if (in_array('menu-item-has-children', $menu_item->classes)) {
		$atts['class'] .= ' dropdown-toggle';

		$atts['aria-expanded']  = 'false';
		$atts['data-bs-toggle'] = 'dropdown';
		$atts['role']           = 'button';

		unset($atts['href']);
    }

    if ($menu_item->current) {
      	$atts['class'] .= ' active';
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'wplite_nav_menu_link_attributes', 10, 4);

/**
 * Filters the CSS class(es) applied to a menu list element.
 *
 * @param  array     $classes
 * @param  \stdClass $args
 * @param  int       $depth
 * @return array
 */
function wplite_nav_menu_submenu_css_class(array $classes, \stdClass $args, int $depth): array {
	return [
		'dropdown-menu',
	];
}
add_filter('nav_menu_submenu_css_class', 'wplite_nav_menu_submenu_css_class', 10, 3);