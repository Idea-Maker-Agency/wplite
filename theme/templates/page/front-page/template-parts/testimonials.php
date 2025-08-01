<?php
use WPLite\Utils\{
  CustomFields,
  Helpers
};

$title = CustomFields::get_field('testimonials_title', 'Testimonials');
$content = CustomFields::get_field('testimonials_content', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.');
$items = CustomFields::get_field('testimonials_items');
?>

<section class="bg-primary bg-opacity-75 py-5 text-center position-relative">
  <div class="container position-relative z-1">
    <h2 class="text-white display-5 fw-bold">
      <?= $title ?>
    </h2>

    <?= wpautop($content) ?>

    <?php if (! empty($items)) { ?>
      <div
        id="testimonial-carousel"
        class="testimonial-carousel carousel slide mt-5 text-start"
        data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php foreach ($items as $key => $item) { ?>
            <div class="testimonial-carousel__item carousel-item active">
              <div class="testimonial-carousel__card">
                <div class="testimonial-carousel__body">
                  <img
                    src="<?=
                      $item['avatar']
                      ? wp_get_attachment_image_url($item['avatar'], [75, 75])
                      : Helpers::get_webp_asset_url('avatar', [75, 75]) ?>"
                    width="75"
                    height="75"
                    alt="<?= $item['full_name'] ?>'s Avatar"
                    loading="lazy"
                    decoding="async"
                    class="testimonial-carousel__avatar img-fluid" />

                  <h3 class="testimonial-carousel__title">
                    <?= $item['full_name'] ?>
                  </h3>

                  <p class="testimonial-carousel__subtitle">
                    <?= $item['job_title'] ?>
                  </p>

                  <p class="testimonial-carousel__text">
                    <?= $item['testimonial'] ?>
                  </p>
                </div>
              </div>
            </div>
          <?php } ?>
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
    <?php } ?>
  </div>
</section>
