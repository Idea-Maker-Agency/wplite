<?php
$text = !empty( $args[0] ) ? $args[0] : '';
$link = !empty( $args[1] ) ? $args[1] : '';
$type = !empty( $args[2]['type'] ) ? $args[2]['type'] : 'a';

// Classes
$classes = wp_parse_args(
  !empty( $args[2]['class'] ) ? $args[2]['class'] : [],
  []
);

if ( !empty( $args['is-button'] ) ) :
  $classes[] = 'btn';

  if ( !empty( $args[2]['variant'] ) ) :
    if ( !empty( $args[2]['outlined'] ) ) :
      $classes[] = 'btn-outline-'. $args[2]['variant'];
    else :
      $classes[] = 'btn-'. $args[2]['variant'];
    endif;
  else :
    $classes[] = 'btn-primary';
  endif;

  if ( !empty( $args[2]['size'] ) ) :
    $classes[] = 'btn-'. $args[2]['size'];
  endif;

  if ( !empty( $args[2]['block'] ) ) :
    $classes[] = 'w-100';
  endif;
else :
  if ( !empty( $args[2]['variant'] ) ) :
    $classes[] = 'text-'. $args[2]['variant'];
  endif;
endif;

// Props
$props = [
  'href' => esc_url( $link ),
  'alt' => esc_html( $text ),
  'rel' => 'nofollow',
];

if ( !empty( $args['id'] ) ) :
  $props['id'] = esc_html( $args['id'] );
endif;

if ( !empty( $args['is-button'] ) ) :
  $props['role'] = 'button';
endif;

if ( !empty( $args['alt'] ) ) :
  $props['alt'] = $args['alt'];
endif;

if ( !empty( $args['target'] ) ) :
  $props['target'] = $args['target'];
endif;

$props['class'] = array_reduce( $classes, function ( string $carry, string $item ): string {
  if ( !empty( $item ) )
    $carry .= " {$item}";

  return $carry;
}, '' );

// Attributes
$attributes = array_reduce( $props, function ( string $carry, string $item ) use ( $props ): string {
  if ( empty( $item ) ) return $carry;

  $key = array_search( $item, $props );

  return sprintf( '%s %s="%s"', $carry, $key, trim( $item ) );
}, '' );
?>

<a
  <?php echo $attributes ?>><?php _e( $text, THEME_TEXT_DOMAIN ) ?></a>
