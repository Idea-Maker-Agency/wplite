<?php
/**
 * Template Name: Sample page template
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

get_header();

$admin_email = get_option('admin_email');
?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-12 col-md-8 col-lg-6">
        <?php if ($sample_text = get_post_meta($post->ID, 'sample_text', true)) { ?>
          <h1 class="fw-bold">
            <?php echo $sample_text ?>
          </h1>
        <?php } ?>

        <?php if ($sample_select = get_post_meta($post->ID, 'sample_select', true)) { ?>
          <p>Sample selected option: <?php echo $sample_select ?></p>
        <?php } ?>

        <?php if ($sample_checkbox = get_post_meta($post->ID, 'sample_checkbox', true)) { ?>
          <p>Sample checked: <?php echo $sample_checkbox ?></p>
        <?php } ?>

        <?php if ($sample_wpeditor = get_post_meta($post->ID, 'sample_wpeditor', true)) { ?>
          <?php echo wpautop($sample_wpeditor) ?>
        <?php } ?>

        <?php if ($sample_image = get_post_meta($post->ID, 'sample_image', true)) { ?>
          <?php echo wp_get_attachment_image($sample_image, 'thumbnail') ?>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
