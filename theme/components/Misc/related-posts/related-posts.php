<?php
use WPLite\Utils\Component;

$cache_key        = "wplite_related_posts_{$post->ID}";
$related_post_ids = get_transient($cache_key);

if (false === $related_post_ids) {
  $query = new WP_Query([
    'posts_per_page' => 6,
    'post__not_in'   => [$post->ID],
    'category__in'   => wp_get_post_categories($post->ID),
    'orderby'        => 'date',
    'fields'         => 'ids',
  ]);

  $related_post_ids = $query->posts;

  set_transient($cache_key, $related_post_ids, HOUR_IN_SECONDS);
}
?>

<?php if (! empty($related_post_ids)) { ?>
  <div class="row">
    <?php foreach ($related_post_ids as $related_post_id) { ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <?php Component::render('article-card', 'Blog', [
          'post' => $related_post_id,
        ]) ?>
      </div>
    <?php } ?>
  </div>
<?php } else { ?>
  <p class="mb-0">
    <?php _e('No related posts found.', THEME_TEXT_DOMAIN) ?>
  </p>
<?php }
