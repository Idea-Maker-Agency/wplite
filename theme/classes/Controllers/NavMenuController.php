<?php

namespace WPLite\Controllers;

if (! defined('ABSPATH')) {
  die;
}

use WP_Post;
use stdClass;

class NavMenuController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_filter('nav_menu_item_attributes', [self::class, 'nav_menu_item_attributes'], 10, 4);
    add_filter('nav_menu_link_attributes', [self::class, 'nav_menu_link_attributes'], 10, 4);
    add_filter('nav_menu_submenu_css_class', [self::class, 'nav_menu_submenu_css_class'], 10, 3);
  }

  /**
   * Filters the HTML attributes applied to a menu's list item element.
   *
   * @param array    $atts      {
   *                            The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
   * @type  string   $class HTML CSS class attribute.
   * @type  string   $id HTML id attribute.
   *                 }
   * @param WP_Post  $menu_item The current menu item object.
   * @param stdClass $args      An object of wp_nav_menu() arguments.
   * @param int      $depth     Depth of menu item. Used for padding.
   *
   * @return array
   */
  public static function nav_menu_item_attributes(
    array $atts,
    WP_Post $menu_item,
    stdClass $args,
    int $depth
  ): array {
    $atts['class'] = 'nav-item';
    $atts['id']    = 'nav-item-'. $menu_item->ID;

    if (in_array('menu-item-has-children', $menu_item->classes)) {
      $atts['class'] .= ' dropdown';
    }

    return $atts;
  }

  /**
   * Filters the HTML attributes applied to a menu item's anchor element.
   *
   * @since 1.0.0
   *
   * @param array    $atts      {
   *                            The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
   * @type  string   $title Title attribute.
   * @type  string   $target Target attribute.
   * @type  string   $rel The rel attribute.
   * @type  string   $href The href attribute.
   * @type  string   $aria-current The aria-current attribute.
   *                 }
   * @param WP_Post  $menu_item The current menu item object.
   * @param stdClass $args      An object of wp_nav_menu() arguments.
   * @param int      $depth     Depth of menu item. Used for padding.
   *
   * @return array
   */
  public static function nav_menu_link_attributes(
    array $atts,
    WP_Post $menu_item,
    stdClass $args,
    int $depth
  ): array {
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

  /**
   * Filters the CSS class(es) applied to a menu list element.
   *
   * @param array    $classes Array of the CSS classes that are applied to the menu <ul> element.
   * @param stdClass $args    An object of wp_nav_menu() arguments.
   * @param int      $depth   Depth of menu item. Used for padding.
   *
   * @return array
   */
  public static function nav_menu_submenu_css_class(
    array $classes,
    stdClass $args,
    int $depth
  ): array {
    return [
      'dropdown-menu',
    ];
  }
}
