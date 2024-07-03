<?php

/**
 * Functional button component renderer.
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
 *
 * @return void
 */
function wplite_button( string $text, array $props ): void {
  $button = new IdeaMaker\WPLite\Components\Button();

  $button->output( $text, $props );
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
