<?php $post = get_post( $args['post'] ); ?>

<?php if ( is_null( $post ) ) return; ?>

<article
  <?php post_class( 'card' ); ?>
  id="post-<?php echo get_the_ID(); ?>"
  aria-label="<?php echo get_the_title(); ?>"
  itemtype="https://schema.org/CreativeWork"
  itemscope>
  <a
    href="<?php echo get_the_permalink(); ?>"
    class="card-img-top">
    <?php if ( has_post_thumbnail() ) : ?>
      <picture>
        <source
          srcset="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'card-image' ); ?>"
          type="image/png">
        <img
          src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'card-image' ); ?>"
          alt="<?php echo get_the_title(); ?>"
          class="img-fluid"
          itemprop="image">
      </picture>
    <?php else : ?>
      <svg width="100%" height="320" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false" style="text-anchor: middle;">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#868e96"></rect>
        <text x="50%" y="50%" fill="#dee2e6" dy=".3em"><?php echo get_the_title(); ?></text>
      </svg>
    <?php endif; ?>
  </a>

  <div
    class="card-body"
    itemprop="text">
    <h3
      class="card-title"
      itemprop="headline">
      <a
        href="<?php echo get_the_permalink(); ?>"
        class="card-title-link"
        rel="bookmark">
        <?php echo get_the_title(); ?>
      </a>
    </h3>

    <p class="card-meta">
      <time datetime="<?php echo get_the_date( 'Y-m-d h:i' ); ?>">
        Posted on <?php echo get_the_date(); ?>
      </time>
    </p>

    <?php echo wpautop( get_the_excerpt() ); ?>

    <a
      href="<?php echo get_the_permalink(); ?>"
      class="card-link">
      Read More
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
    </a>
  </div>
</article>
