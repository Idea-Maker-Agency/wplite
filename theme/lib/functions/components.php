<?php

/**



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
