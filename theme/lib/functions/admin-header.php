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
