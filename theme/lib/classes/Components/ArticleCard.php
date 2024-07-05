<?php
/**
 * The class for the article card component.
 *
 * @since 1.0.0
 */
namespace IdeaMaker\WPLite\Components;

class ArticleCard extends Component {
  /**
   * Register default parameters.
   *
   * @since 1.0.0
   *
   * @return void
   */
  protected function register(): void {
    $this->params = [
      'post' => null,
    ];
  }

  /**
   * Format properties.
   *
   * @since 1.0.0
   *
   * @return void
   */
  protected function format(): void {}

  /**
   * Output the component.
   *
   * @since 1.0.0
   *
   * @param \WP_Post    $post       The WP post object.
   *
   * @return void
   */
  public function output( \WP_Post $post ): void {
    $this->props['post'] = $post;

    $this->render();
  }
}
