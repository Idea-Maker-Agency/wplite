<?php
defined( 'ABSPATH' ) || die( 'Access denied.' );

$text = !empty( $args[0] ) ? $args[0] : '';

// Classes
$classes = wp_parse_args(
  !empty( $args[2]['class'] ) ? $args[2]['class'] : [],
  []
);

if ( !empty( $args[1]['variant'] ) ) :
  if ( !empty( $args[1]['outlined'] ) ) :
    $classes[] = 'btn-outline-'. $args[1]['variant'];
  else :
    $classes[] = 'btn-'. $args[1]['variant'];
  endif;
else :
  $classes[] = 'btn-primary';
endif;

if ( !empty( $args[1]['size'] ) ) :
  $classes[] = 'btn-'. $args[1]['size'];
endif;

if ( !empty( $args[1]['block'] ) ) :
  $classes[] = 'w-100';
endif;

// Props
$props = [
  'type' => 'button',
  'title' => esc_html( $title ),
];

if ( !empty( $args['id'] ) ) :
  $props['id'] = esc_html( $args['id'] );
endif;

if ( !empty( $args['type'] ) ) :
  $props['type'] = esc_html( $args['type'] );
endif;

if ( !empty( $args['title'] ) ) :
  $props['title'] = $args['title'];
endif;

$props['class'] = array_reduce( $classes, function ( string $carry, string $item ): string {
  if ( !empty( $item ) )
    $carry .= " {$item}";

  return $carry;
}, 'btn' );

// Attributes
$attributes = array_reduce( $props, function ( string $carry, string $item ) use ( $props ): string {
  if ( empty( $item ) ) return $carry;

  $key = array_search( $item, $props );

  return sprintf( '%s %s="%s"', $carry, $key, trim( $item ) );
}, '' );
?>

<button
  <?php echo $attributes ?>><?php _e( $text, THEME_TEXT_DOMAIN ) ?></button>
