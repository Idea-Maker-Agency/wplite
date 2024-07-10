<?php
extract( $args );

// Source sets
$srcsets = [];

$srcsets[1200] = !empty( $sizes['xl'] ) ? esc_url( $sizes['xl'] ) : null;
$srcsets[992] = !empty( $sizes['lg'] ) ? esc_url( $sizes['lg'] ) : null;
$srcsets[768] = !empty( $sizes['md'] ) ? esc_url( $sizes['md'] ) : null;
$srcsets[576] = !empty( $sizes['sm'] ) ? esc_url( $sizes['sm'] ) : null;
$srcsets[320] = !empty( $sizes['xs'] ) ? esc_url( $sizes['xs'] ) : null;

$srcsets = array_filter( $srcsets, fn ( string|null $srcset ): bool => !is_null( $srcset ) );

// Props
$props = [
  'width' => intval( $width ),
  'height' => intval( $height ),
  'loading' => 'lazy',
  'decoding' => 'async',
];

$props['src'] = esc_url( $src );
$props['srcset'] = array_reduce( $srcsets, function ( string $carry, string $item ) use ( $srcsets ): string {
  $viewport = array_search( $item, $srcsets );

  $carry = $item .' '. $viewport .'w, '. $carry;

  return $carry;
}, esc_url( $src ) .' 1400w' );
$props['sizes'] = array_reduce( $srcsets, function ( string $carry, string $item ) use ( $srcsets ): string {
  $viewport = array_search( $item, $srcsets );

  $carry = '(max-width: '. $viewport .'px) '. $viewport .'px, '. $carry;

  return $carry;
}, '100vw' );

$props['alt'] = !empty( $alt ) ? esc_html( $alt ) : null;
$props['id'] = !empty( $id ) ? esc_html( $id ) : null;
$props['class'] = array_reduce( !empty( $class ) ? $class : [], function ( string $carry, string $item ): string {
  if ( !empty( $item ) )
    $carry .= " {$item}";

  return $carry;
}, 'img-fluid' );

$props = array_filter( $props, fn ( string|null $value ): bool => !empty( $value ) );

// Attributes
$attributes = array_reduce( $props, function ( string $carry, string $item ) use ( $props ): string {
  if ( empty( $item ) ) return $carry;

  $key = array_search( $item, $props );

  return sprintf( '%s %s="%s"', $carry, $key, trim( $item ) );
}, '' );
?>

<img <?php echo $attributes ?> />
