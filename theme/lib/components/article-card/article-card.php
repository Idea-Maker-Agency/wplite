<?php
$post = get_post($args['post']);

$default_args = [];

extract(wp_parse_args($args, $default_args));

if (is_null($post)) return;
?>

<article
  <?php post_class('article-card card h-100', $post) ?>
  id="post-<?php echo $post->ID ?>"
  aria-label="<?php echo get_the_title($post) ?>"
  itemtype="https://schema.org/CreativeWork"
  itemscope>
  <a
    href="<?php echo get_permalink($post) ?>"
    class="card-img-top">
    <?php if (has_post_thumbnail($post)) { ?>
      <img
        src="<?php echo get_the_post_thumbnail_url($post->ID, 'card-image') ?>"
        width="420"
        height="320"
        srcset="
          <?php echo get_the_post_thumbnail_url($post->ID, 'card-image') ?> 1024w,
          <?php echo get_the_post_thumbnail_url($post->ID, 'thumbnail') ?> 320w
        "
        sizes="(min-width: 420px) 420px, 100vw"
        alt="<?php echo $post->post_title ?>"
        loading="lazy"
        decoding="async"
        class="img-fluid" />
    <?php } else { ?>
      <svg
        width="100%"
        height="320"
        xmlns="http://www.w3.org/2000/svg"
        role="img"
        aria-label="Placeholder: Image cap"
        preserveAspectRatio="xMidYMid slice"
        focusable="false"
        style="text-anchor: middle;">
        <title>Placeholder</title>
        <rect
          width="100%"
          height="100%"
          fill="#868e96"></rect>
        <text
          x="50%"
          y="50%"
          fill="#dee2e6"
          dy=".3em">
          <?php echo get_the_title($post) ?>
        </text>
      </svg>
    <?php } ?>
  </a>

  <div
    class="card-body"
    itemprop="text">
    <h3
      class="card-title"
      itemprop="headline">
      <a
        href="<?php echo get_permalink($post) ?>"
        class="card-title-link"
        rel="bookmark">
        <?php echo get_the_title($post) ?>
      </a>
    </h3>

    <p class="card-meta">
      <time datetime="<?php echo get_the_date('Y-m-d h:i', $post) ?>">
        Posted on <?php echo get_the_date('', $post) ?>
      </time>
    </p>

    <?php echo wpautop(get_the_excerpt($post)) ?>

    <a
      href="<?php echo get_permalink($post) ?>"
      class="card-link"
      rel="noopener noreferrer"
      alt="Read more about <?php echo get_the_title($post) ?>">
      Read More
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="16"
        height="16"
        fill="currentColor"
        class="bi bi-arrow-right ms-2">
        <path
          fill-rule="evenodd"
          d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
      </svg>
    </a>
  </div>
</article>
