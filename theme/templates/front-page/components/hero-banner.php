<?php
use WPLite\Utils\CustomFields;

$bg_image_id = CustomFields::get_field('hero_banner_bg');

$title   = CustomFields::get_field('hero_banner_title', 'Lorem ipsum dolor sit amet');
$content = CustomFields::get_field('hero_banner_content', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantiumo');

$cta_primary_text = CustomFields::get_field('hero_banner_cta_primary_text');
$cta_primary_url  = CustomFields::get_field('hero_banner_cta_primary_url');

$cta_secondary_text = CustomFields::get_field('hero_banner_cta_secondary_text');
$cta_secondary_url  = CustomFields::get_field('hero_banner_cta_secondary_url');
?>

<section class="hero-banner text-white py-5 text-center d-flex align-items-center justify-content-center position-relative">
  <div class="container py-lg-5 px-lg-4 position-relative z-1">
    <div class="row">
      <div class="col-10 col-sm-9 col-lg-6 mx-auto">
        <h1 class="hero-banner__heading mb-4 fw-bold">
          <?= $title ?>
        </h1>

        <?= wpautop($content) ?>

        <div class="hero-banner__actions mt-4 mt-lg-5 d-grid gap-2 d-sm-flex justify-content-sm-center">
          <?php if ($cta_primary_url) { ?>
            <a
              href="<?= $cta_primary_url ?>"
              class="btn btn-primary"
              rel="nofollow noopener noreferrer"
              alt="<?= $cta_primary_text ?>"
              aria-label="<?= $cta_primary_text ?>" >
              <?= $cta_primary_text ?>
            </a>
          <?php } ?>

          <?php if ($cta_secondary_url) { ?>
            <a
              href="https://"
              class="btn btn-outline-light"
              rel="nofollow noopener noreferrer"
              alt="<?= $cta_secondary_text ?>"
              aria-label="<?= $cta_secondary_text ?>" >
              <?= $cta_secondary_text ?>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <div class="w-100 h-100 bg-dark bg-opacity-50 position-absolute top-0 start-0 z-n2"></div>

  <?php if ($bg_image_id) { ?>
    <img
      src="<?= wp_get_attachment_image_url($bg_image_id, [1920, 1080]) ?>"
      srcset="
        <?= wp_get_attachment_image_url($bg_image_id, [1920, 1080]) ?> 1920w,
        <?= wp_get_attachment_image_url($bg_image_id, [1024, 768]) ?> 1024w,
        <?= wp_get_attachment_image_url($bg_image_id, [320, 500]) ?> 320w"
      sizes="(min-width: 1920px) 1920px, (min-width: 1024px) 1024px, 100vw"
      width="1920"
      height="1080"
      alt="Hero image"
      decoding="async"
      class="w-100 h-100 object-fit-cover position-absolute top-0 start-0 z-n1" />
  <?php } ?>
</section>
