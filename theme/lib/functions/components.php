<?php

/**
 * Functional image component renderer.
 *
 * @since 1.0.0
 *
 * @param int       $id       The attachment image ID.
 *
 * @return void
 */
function wplite_image( int $id, array $props = [] ): void {
  $image = new IdeaMaker\WPLite\Components\Image();

  $image->output( $id, $props );
}


/**
 * Functional article card component renderer.
 *
 * @since 1.0.0
 *
 * @param \WP_Post    $post       The WP post object.
 *
 * @return void
 */
function wplite_article_card( \WP_Post $post ): void {
  $article_card = new IdeaMaker\WPLite\Components\ArticleCard();

  $article_card->output( $post );
}
