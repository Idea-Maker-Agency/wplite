<?php
/**
 * The template for displaying front-page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

get_header();
?>

<?php get_template_part('templates/front-page/components/hero', 'banner') ?>
<?php get_template_part('templates/front-page/components/intro') ?>
<?php get_template_part('templates/front-page/components/features') ?>
<?php get_template_part('templates/front-page/components/faqs') ?>

<section
  id=""
  class="bg-primary bg-opacity-75 py-5 position-relative">
  <div class="container position-relative z-1">
    <h2 class="text-white display-5 fw-bold text-center">Testimonials</h2>

    <div
      id="testimonial-carousel"
      class="testimonial-carousel carousel slide mt-5"
      data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="testimonial-carousel__item carousel-item active">
          <div class="testimonial-carousel__card">
            <div class="testimonial-carousel__body">
              <img
                src="<?= wplite_get_webp_url('avatar', '', [75, 75]) ?>"
                width="75"
                height="75"
                alt="Person's Avatar"
                loading="lazy"
                decoding="async"
                class="testimonial-carousel__avatar img-fluid" />
              <h3 class="testimonial-carousel__title">Person's Name</h3>
              <p class="testimonial-carousel__subtitle">Person's Name</p>
              <p class="testimonial-carousel__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
        <div class="testimonial-carousel__item carousel-item">
          <div class="testimonial-carousel__card">
            <div class="testimonial-carousel__body">
              <img
                src="<?= wplite_get_webp_url('avatar', '', [75, 75]) ?>"
                width="75"
                height="75"
                alt="Person's Avatar"
                loading="lazy"
                decoding="async"
                class="testimonial-carousel__avatar img-fluid" />
              <h3 class="testimonial-carousel__title">Person's Name</h3>
              <p class="testimonial-carousel__subtitle">Person's Name</p>
              <p class="testimonial-carousel__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
        <div class="testimonial-carousel__item carousel-item">
          <div class="testimonial-carousel__card">
            <div class="testimonial-carousel__body">
              <img
                src="<?= wplite_get_webp_url('avatar', '', [75, 75]) ?>"
                width="75"
                height="75"
                alt="Person's Avatar"
                loading="lazy"
                decoding="async"
                class="testimonial-carousel__avatar img-fluid" />
              <h3 class="testimonial-carousel__title">Person's Name</h3>
              <p class="testimonial-carousel__subtitle">Person's Name</p>
              <p class="testimonial-carousel__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#testimonial-carousel"
        data-bs-slide="prev">
        <span
          class="carousel-control-prev-icon"
          aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#testimonial-carousel"
        data-bs-slide="next">
        <span
          class="carousel-control-next-icon"
          aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

<?php get_template_part('template-parts/sample/sample') ?>

<?php
get_footer();
