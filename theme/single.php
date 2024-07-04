<?php
/**
 * Template: Post
 *
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

<?php
while ( have_posts() ) :
  the_post();

  $author_id = get_the_author_meta( 'ID' );
?>
  <section class="py-5">
    <div class="container">
      <div class="row">
        <main class="col-12 col-lg-9 pe-lg-4 pe-xl-5 mb-5 mb-lg-0">
          <article
            id="post-<?php echo get_the_ID(); ?>"
            aria-label="<?php echo get_the_title(); ?>"
            itemtype="https://schema.org/CreativeWork"
            itemscope>
            <header class="mb-4">
              <h1
                class="fw-bold"
                itemprop="headline">
                <?php echo get_the_title(); ?>
              </h1>

              <dl class="mb-0 d-flex align-items-center">
                <dt>Posted on</dt>
                <dd class="ms-1 mb-0">
                  <time itemprop="datePublished" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>">
                    <?php echo get_the_date(); ?>
                  </time>
                </dd>
              </dl>
            </header>

            <div itemprop="text">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php echo get_the_post_thumbnail( get_the_ID(), 'featured-image', [ 'class' => 'mb-4 rounded-4' ]); ?>
              <?php else : ?>
                <svg width="640" height="320" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false" class="mb-4 rounded-4" style="text-anchor: middle;">
                  <title>Placeholder</title>
                  <rect width="100%" height="100%" fill="#868e96"></rect>
                  <text x="50%" y="50%" fill="#dee2e6" dy=".3em"><?php echo get_the_title(); ?></text>
                </svg>
              <?php endif; ?>

              <?php echo wpautop( get_the_content() ); ?>
            </div>

            <footer class="mt-4">
              <div class="d-flex align-items-center column-gap-2 small">
                <?php echo get_avatar( $author_id, 48, '', '', [ 'class' => 'rounded-circle' ] ); ?>

                <dl class="mb-0">
                  <dt>Posted by</dt>
                  <dd
                    class="mb-0"
                    itemprop="author">
                    <?php echo get_the_author(); ?>
                  </dd>
                </dl>
              </div>
            </footer>
          </article>

          <?php if ( comments_open() || get_comments_number() ) : ?>
            <?php comments_template(); ?>
          <?php endif; ?>

          <?php
          the_post_navigation( [
            'next_text' => '<span class="nav-links__label" aria-hidden="true">' . __( 'Next', THEME_TEXT_DOMAIN ) . '</span> ' .
                          '<span class="screen-reader-text">' . __( 'Next post:', THEME_TEXT_DOMAIN ) . '</span> ' .
                          '<span class="nav-links__text">%title</span>',
            'prev_text' => '<span class="nav-links__label" aria-hidden="true">' . __( 'Previous', THEME_TEXT_DOMAIN ) . '</span> ' .
                          '<span class="screen-reader-text">' . __( 'Previous post:', THEME_TEXT_DOMAIN ) . '</span> ' .
                          '<span class="nav-links__text">%title</span>',
          ] );
          ?>
        </main>

        <aside class="col-12 col-lg-3">
          <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'primary-sidebar' ); ?>
          <?php endif; ?>
        </aside>
      </div>
    </div>
  </section>

  <section class="bg-light py-5">
    <div class="container">
      <h2 class="mb-4 fw-bold">Related Posts</h2>

      <?php get_template_part( 'lib/templates/widgets/related', 'posts' ); ?>
    </div>
  </section>
<?php endwhile; ?>

<?php get_footer(); ?>
