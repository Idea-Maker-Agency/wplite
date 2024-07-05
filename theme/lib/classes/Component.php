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
   * The component name.
   *
   * @since 1.0.0
   *
   * @var string
   */
  private static $name;

  /**
   * Gets the component's template path.
   *
   * @since 1.0.0
   *
   * @return string
   */
  protected static function get_path(): string {
    if ( empty( self::$name ) ) return '';

    return 'components/'. self::$name .'/'. self::$name;
  }

  /**
   * Enqueues the component scripts and styles if they exists.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public static function enqueue_assets(): void {
    if ( file_exists( THEME_DIR_PATH .'/'. self::get_path() . '.css' ) ) :
      wp_enqueue_style(
        'wplite-'. self::$name,
        THEME_DIR_URI .'/'. self::get_path() .'.css',
        [],
        '1.0.0',
        false
      );
    endif;

    if ( file_exists( THEME_DIR_PATH .'/'. self::get_path() . '.js' ) ) :
      wp_enqueue_script(
        'wplite-'. self::$name,
        THEME_DIR_URI .'/'. self::get_path() .'.js',
        [],
        '1.0.0',
        true
      );
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
    self::$name = $component;

    get_template_part(
      self::get_path(),
      null,
      $args
    );
  }

  /**
   * Registers the component.
   *
   * @since 1.0.0
   *
   * @param string    $component      The component name.
   *
   * @return void
   */
  public static function register( string $component ): void {
    self::$name = $component;

    add_action(
      'wp_enqueue_scripts',
      [ static::class, 'enqueue_assets' ],
      15
    );
  }
}
