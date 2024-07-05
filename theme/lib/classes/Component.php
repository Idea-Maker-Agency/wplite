<?php

/**
 * The abstract class for components.
 *
 * @since 1.0.0
 */
namespace IdeaMaker\WPLite;

defined( 'ABSPATH' ) || die( 'Access denied.' );

class Component {
  /**
   * The components array.
   *
   * @since 1.0.0
   *
   * @var array
   */
  public static $components = [];

  /**
   * Enqueues the component scripts and styles if they exists.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public static function enqueue_assets(): void {
    if ( 0 < count( self::$components ) ) :
      foreach( self::$components as $component ) :
        if ( file_exists( THEME_DIR_PATH .'/components/'. $component .'/'. $component .'.css' ) ) :
          wp_enqueue_style(
            'wplite-'. $component,
            THEME_DIR_URI .'/components/'. $component .'/'. $component .'.css',
            [],
            '1.0.0',
            false
          );
        endif;

        if ( file_exists( THEME_DIR_PATH .'/components/'. $component .'/'. $component .'.js' ) ) :
          wp_enqueue_script(
            'wplite-'. $component,
            THEME_DIR_URI .'/components/'. $component .'/'. $component .'.js',
            [],
            '1.0.0',
            true
          );
        endif;
      endforeach;
    endif;
  }

  /**
   * Renders the component's template.
   *
   * @since 1.0.0
   *
   * @param string    $component      The component name.
   * @param mixed     $args           The set of arguments to pass to the component.
   *
   * @return void
   */
  public static function render( string $component, mixed ...$args ): void {
    get_template_part(
      '/components/'. $component .'/'. $component,
      null,
      $args
    );
  }

  /**
   * Adds new component to register.
   *
   * @param string    $component      The component name.
   *
   * @return void
   */
  public static function add( string $component ): void {
    self::$components[] = $component;
  }

  /**
   * Registers the component.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public static function register(): void {
    add_action(
      'wp_enqueue_scripts',
      [ static::class, 'enqueue_assets' ],
      15
    );
  }
}
