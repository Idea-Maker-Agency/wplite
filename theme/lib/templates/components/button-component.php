<?php
if ( empty( $args['tag'] ) ) return;

// Classes
$classes = [
  'btn',
];

if ( !empty( $args['variant'] ) || $args['outlined'] )
  $classes[] = 'btn-'. ($args['outlined'] ? 'outline-' : '') . $args['variant'];

if ( !empty( $args['size'] ) )
  $classes[] = 'btn-'. $args['size'];

if ( $args['block'] )
  $classes[] = 'w-100';

// Attributes
$attributes = array_map(
  function ( string $key, string $value ) use ( $args ) : string {
    if ( ('type' === $key) && ('a' === $args['tag']) ) :
      return 'role="button"';
    endif;

    return $key .'="'. esc_html( $value ) .'"';
  },
  array_keys( $args['attrs'] ),
  $args['attrs']
);
?>

<<?php echo $args['tag']; ?>
  <?php echo implode( ' ', $attributes ); ?>
  class="<?php echo implode( ' ', $classes ); ?>">
  <?php echo $args['text']; ?>
</<?php echo $args['tag']; ?>>
