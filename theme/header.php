<?php
/**
 * The template for displaying the header.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use WPLite\Utils\Component;

?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>
  <head>
    <meta
      charset="<?php bloginfo('charset') ?>" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1">

    <?php if (is_single()) { ?>
      <meta
        name="description"
        content="<?= wp_strip_all_tags(get_the_excerpt(), true) ?>" />
    <?php } ?>

    <title>
      <?php wp_title(' | ', true, 'right') ?> <?= bloginfo('name') ?>
    </title>

    <link
      rel="profile"
      href="http://gmpg.org/xfn/11" />
    <link
      rel="pingback"
      href="<?php bloginfo('pingback_url') ?>" />

    <?php
        if (is_singular() && get_option('thread_comments')) {
          wp_enqueue_script('comment-reply');
        }
?>

    <?php wp_head() ?>
  </head>

  <body <?php body_class() ?>>
    <?php
if (function_exists('wp_body_open')) {
  wp_body_open();
}
?>

    <nav class="header navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <?php Component::render('logo', 'Misc', [
  'link_class' => 'navbar-brand',
]) ?>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#header-menu"
          aria-controls="header-menu"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div
          id="header-menu"
          class="collapse navbar-collapse">
          <?php
            if ($main_nav_menu_id = get_theme_mod('wplite_navigation_menu')) {
              wp_nav_menu([
              'menu'        => $main_nav_menu_id,
              'menu_class'  => 'navbar-nav ms-auto mb-2 mb-lg-0',
              'container'   => '',
              'fallback_cb' => false,
            ]);
            }
?>
        </div>
      </div>
    </nav>

    <main>
