<?php
/**
 * The template for displaying the footer.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use WPLite\Utils\{
  Component,
  View
};

?>
    </main>

    <footer class="footer py-5">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-4">
            <?php
            Component::render('logo', 'Misc', [
              'width'      => 95,
              'height'     => 45,
              'link_class' => 'footer-logo mb-4 fs-4 d-inline-block',
            ]);
?>
          </div>

          <div class="col-12 col-lg-4">
            <?php if ($quick_links_heading = get_theme_mod('wplite_footer_quick_links_heading')) { ?>
              <h4 class="mb-3 h5 fw-bold">
                <?= __($quick_links_heading, THEME_TEXT_DOMAIN) ?>
              </h4>
            <?php } ?>

            <?php
            if ($quick_links_menu_id = get_theme_mod('wplite_footer_quick_links_menu')) {
              wp_nav_menu([
                  'menu'        => $quick_links_menu_id,
                  'menu_class'  => 'list-unstyled d-grid row-gap-2',
                  'container'   => '',
                  'fallback_cb' => false,
                  ]);
            }
?>
          </div>

          <div class="col-12 col-lg-4">
            <?php if ($get_in_touch_heading = get_theme_mod('wplite_footer_get_in_touch_heading')) { ?>
              <h4 class="mb-3 h5 fw-bold">
                <?= __($get_in_touch_heading, THEME_TEXT_DOMAIN) ?>
              </h4>
            <?php } ?>

            <?php Component::render('social-links', 'Misc') ?>
          </div>
        </div>
      </div>
    </footer>

    <div class="copyright py-2">
      <div class="container">
        <p class="mb-0 text-center">
          <a href="<?= site_url() ?>">WPLite</a> &copy; <?= date('Y') ?> | <?= get_theme_mod('wplite_copyright_text') ?? '' ?>
        </p>
      </div>
    </div>

    <?php wp_footer() ?>
  </body>
</html>
