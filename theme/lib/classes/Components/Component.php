<?php

/**
 * The abstract class for components.
 *
 * @since 1.0.0
 */
namespace IdeaMaker\WPLite\Components;

defined( 'ABSPATH' ) || die( 'Access denied.' );

abstract class Component {
  /**
   * The component parameters.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected $params = [];

  /**
   * The component properties.
   *
   * @since 1.0.0
   *
   * @access public
   */
  public $props = [];

   /**
   * Set up our parameters and component.
   *
   * @since 1.0.0
   *
   * @param array     $params     The parameters for our component
   * @param boolean   $format     Query and format by default
   */
  final public function __construct( array $params = [], bool $format = true ) {
    $this->register();

    $this->params = wp_parse_args( $params, $this->params );

    if( $format ) :
      $this->format();
    endif;
  }

  /**
   * Registers the default parameters for the component
   * It should be used to set $this->params with the default parameters.
   *
   * @since 1.0.0
   *
   * @return void
   */
  abstract protected function register(): void;

  /**
   * Used for formatting or querying of data based on parameters.
   *
   * @since 1.0.0
   *
   * @return void
   */
  abstract protected function format(): void;

  /**
   * Renders the component.
   *
   * @since 1.0.0
   *
   * @param bool    $echo       Whether a template should be displayed or returned as a string.
   */
  public final function render( bool $echo = true ) {
    if( !$this->props ) return;

    $component_name = preg_replace_callback( '/[A-Z]/', function ( array $matches ): string {
      return '-'. strtolower( reset( $matches ) );
    }, (new \ReflectionClass($this))->getShortName() );

    ob_start();

    get_template_part(
      'lib/templates/components/'. preg_replace( '/^./', '', $component_name ),
      'component',
      $this->props
    );

    $output = ob_get_contents();
    ob_end_clean();

    if ( $echo ) :
      echo $output;
    else :
      return $output;
    endif;
  }
}
