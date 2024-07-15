<?php

/**
 * Admin notices.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'admin_notices', 'wplite_admin_notices' );
function wplite_admin_notices(): void {
  if( !class_exists( 'WPCF7' ) ) :
  ?>
    <div class="notice notice-warning">
      <p>
        <strong>Warning:</strong> <?php _e( 'The theme requires Contact Form 7 plugin.', THEME_TEXT_DOMAIN ) ?>
      </p>
    </div>
  <?php
  endif;
}

/**
 * Remove editor from pages that use page template.
 *
 * @return void
 */
add_action( 'admin_init', 'wplite_remove_page_template_editor' );
function wplite_remove_page_template_editor(): void {
  $post_id = $_GET['post'];

  if ( empty( $post_id ) ) return;

  $page_template = get_post_meta( $post_id, '_wp_page_template', true );

  if ( !in_array( $page_template, [ 'templates/contact.php' ] ) ) return;

  remove_post_type_support( 'page', 'editor' );
}
