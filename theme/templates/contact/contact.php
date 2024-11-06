<?php
/**
 * Template Name: Contact page
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
        <h1 class="fw-bold">Contact Us</h1>
        <p class="mb-4 mb-lg-5">
          Need to get in touch with us? <br/>
          Either fill out the form or email us at <a href="mailto:<?php echo $admin_email ?>"><?php echo $admin_email ?></a>
        </p>

        <?php if (class_exists('WPCF7')) { ?>
          <?php if ($form = wpcf7_get_contact_form_by_title('Contact Us')) { ?>
            <?php echo do_shortcode('[contact-form-7 id="' . $form->id() . '"]') ?>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
