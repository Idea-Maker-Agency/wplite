<?php
$default_args = [
  'variant' => 'primary',
];

extract( wp_parse_args( $args, $default_args ) );

// Classes
$classes = wp_parse_args(
  !empty( $class ) ? $class : [],
  []
);

if ( !empty( $as_button ) ) :
  $classes[] = 'btn';

  $classes[] = !empty( $size ) ? 'btn-'. esc_html( $size ) : null;
  $classes[] = !empty( $block ) ? 'w-100' : null;

  if ( !empty( $variant ) ) :
    $classes[] = !empty( $outlined ) ? 'btn-outline-'. esc_html( $variant ) : 'btn-'. esc_html( $variant );
  else :
    $classes[] = 'btn-primary';
  endif;
else :
  $classes[] = !empty( $variant ) ? 'text-'. esc_html( $variant ) : null;
endif;

$classes = array_filter( $classes, fn ( string|null $class ): bool => !is_null( $class ) );

// Props
$props = [
  'href' => esc_url( $url ),
  'rel' => 'nofollow',
];

$props['id'] = !empty( $id ) ? esc_html( $id ) : null;
$props['alt'] = !empty( $alt ) ? esc_html( $alt ) : esc_html( $text );
$props['target'] = !empty( $target ) ? esc_html( $target ) : null;
$props['role'] = !empty( $as_button ) ? 'button' : null;
$props['class'] = array_reduce( $classes, function ( string $carry, string $item ): string {
  if ( !empty( $item ) )
    $carry .= " {$item}";

  return $carry;
}, '' );

$props = array_filter( $props, fn ( string|null $value ): bool => !empty( $value ) );

// Attributes
$attributes = array_reduce( $props, function ( string $carry, string $item ) use ( $props ): string {
  if ( empty( $item ) ) return $carry;

  $key = array_search( $item, $props );

  return sprintf( '%s %s="%s"', $carry, $key, trim( $item ) );
}, '' );
?>

<a <?php echo $attributes ?>><?php _e( $text, THEME_TEXT_DOMAIN ) ?></a>
