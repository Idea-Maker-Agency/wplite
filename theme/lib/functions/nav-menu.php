<?php

/**
 * Register nav menus.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'init', 'wplite_init_menu' );
function wplite_init_menu (): void {
  register_nav_menu( 'header-menu', __( 'Header Menu' ) );
}

/**
 * Filters the HTML attributes applied to a menu's list item element.
 *
 * @since 1.0.0
 *
 * @param array     $atts       {
 *    The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
 *    @type string    $class        HTML CSS class attribute.
 *    @type string    $id           HTML id attribute.
 * }
 * @param WP_Post   $menu_item  The current menu item object.
 * @param stdClass  $args       An object of wp_nav_menu() arguments.
 * @param int       $depth      Depth of menu item. Used for padding.
 *
 * @return array    $atts
 */
add_filter( 'nav_menu_item_attributes', 'wplite_nav_menu_item_attributes', 10, 4 );
function wplite_nav_menu_item_attributes (
  array $atts,
  WP_Post $menu_item,
  stdClass $args,
  int $depth
): array {
  $atts['class'] = 'nav-item';
  $atts['id'] = 'nav-item-'. $menu_item->ID;

  if ( in_array( 'menu-item-has-children', $menu_item->classes ) ) :
    $atts['class'] .= ' dropdown';
  endif;

  return $atts;
}

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * @since 1.0.0
 *
 * @param array     $atts       {
 *    The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *    @type string $title        Title attribute.
 *    @type string $target       Target attribute.
 *    @type string $rel          The rel attribute.
 *    @type string $href         The href attribute.
 *    @type string $aria-current The aria-current attribute.
 * }
 * @param WP_Post   $menu_item  The current menu item object.
 * @param stdClass  $args       An object of wp_nav_menu() arguments.
 * @param int       $depth      Depth of menu item. Used for padding.
 *
 * @return array    $atts
 */
add_filter( 'nav_menu_link_attributes', 'wplite_nav_menu_link_attributes', 10, 4 );
function wplite_nav_menu_link_attributes (
  array $atts,
  WP_Post $menu_item,
  stdClass $args,
  int $depth
): array {
  if ( 0 < $depth ) :
    $atts['class'] = 'dropdown-item';
  else :
    $atts['class'] = 'nav-link';

    if ( in_array( 'menu-item-has-children', $menu_item->classes ) ) :
      $atts['class'] .= ' dropdown-toggle';

      $atts['aria-expanded'] = 'false';
      $atts['data-bs-toggle'] = 'dropdown';
      $atts['role'] = 'button';

      unset( $atts['href'] );
    endif;
  endif;

  if ( $menu_item->current ) :
    $atts['class'] .= ' active';
  endif;

  return $atts;
}

/**
 * Filters the CSS class(es) applied to a menu list element.
 *
 * @param array     $classes  Array of the CSS classes that are applied to the menu <ul> element.
 * @param stdClass  $args     An object of wp_nav_menu() arguments.
 * @param int       $depth    Depth of menu item. Used for padding.
 *
 * @return array
 */
add_filter( 'nav_menu_submenu_css_class', 'wplite_nav_menu_submenu_css_class', 10, 3 );
function wplite_nav_menu_submenu_css_class (
  array $classes,
  stdClass $args,
  int $depth
) : array {
  return [
    'dropdown-menu',
  ];
}
