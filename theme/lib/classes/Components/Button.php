<?php
/**
 * The class for the button component.
 *
 * @since 1.0.0
 */
namespace IdeaMaker\WPLite\Components;

defined( 'ABSPATH' ) || die( 'Access denied.' );

class Button extends Component {
  /**
   * Register default parameters.
   *
   * @since 1.0.0
   *
   * @return void
   */
  protected function register(): void {
    $this->params = [
      'variant' => 'primary', // 'primary' | 'success' | 'warning' | 'danger' | 'info' | 'secondary'. Defaults to 'primary'.
      'size'  => null, // 'sm' | 'lg' } null. Defaults to null.
      'outlined' => false,
      'block' => false,
      'tag' => 'button', // 'button' | 'reset' | 'a'. Defaults to 'button'.
      'attrs' => [
        'type' => 'button',  // 'button' | 'submit' | 'reset' | 'a'. Defaults to 'button'.
      ]
    ];
  }

  /**
   * Format properties.
   *
   * @since 1.0.0
   *
   * @return void
   */
  protected function format(): void {
    foreach( $this->params as $key => $value ) :
      if( is_array( $value ) ) :
        $this->props[$key] = $value;
      else :
        $this->props[$key] = esc_html( $value );
      endif;
    endforeach;
  }

  /**
   * Output the component.
   *
   * @since 1.0.0
   *
   * @param string    $text       The button text.
   * @param array     $props      {
   *    The button overrides or custom props.
   *    @param string     $variant      The style variant of the button.
   *    @param string     $size         The size variant of the button.
   *    @param bool       $outlined     If true, the button will have an outlined style.
   *    @param bool       $block        If true, the button will expand to the full width of its parent.
   *    @param string     $tag          The HTML tag to render, allowing for custom components or elements.
   *    @param array      $attrs        The HTML attributes to apply to the button.
   * }
   */
  public function output( string $text, array $props = [] ) {
    if ( !empty( $props['attrs'] ) )
      $props['attrs'] = wp_parse_args( $this->props['attrs'], $props['attrs'] );

    $this->props = wp_parse_args( $props, $this->props );
    $this->props['text'] = esc_html( $text );

    $this->render();
  }
}


