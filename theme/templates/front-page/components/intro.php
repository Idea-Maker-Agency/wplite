<?php
use WPLite\Utils\CustomFields;

$featured_image_id = CustomFields::get_field('intro_featured_image');

$title = CustomFields::get_field(
  'intro_title',
  'Lorem ipsum'
);
$content = CustomFields::get_field(
  'intro_content',
  'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident'
);

$cta_text = CustomFields::get_field('intro_cta_text');
$cta_url = CustomFields::get_field('intro_cta_url');
?>

<section class="py-5">
  <div class="container">
    <div class="row align-items-center ">
      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <?php if ($featured_image_id) { ?>
          <img
            src="<?= wp_get_attachment_image_url($featured_image_id, [640, 480]) ?>"
            srcset="
              <?= wp_get_attachment_image_url($featured_image_id, [640, 480]) ?> 640w,
              <?= wp_get_attachment_image_url($featured_image_id, [540, 360]) ?> 540w,
              <?= wp_get_attachment_image_url($featured_image_id, [320, 230]) ?> 320w"
            sizes="(min-width: 640px) 640px, (min-width: 540px) 540px, 100vw"
            width="640"
            height="480"
            alt="Alt text"
            decoding="async"
            class="img-fluid rounded-4" />
        <?php } ?>
      </div>
      <div class="col-12 col-lg-6">
        <div class="col-lg-10 mx-auto">
          <h2 class="mb-3 display-6 fw-bold">
            <?= $title ?>
          </h2>

          <?= wpautop($content) ?>

          <?php if ($cta_url) { ?>
            <a
              href="https://"
              class="btn btn-primary mt-3"
              role="button"
              alt="<?= $cta_text ?>"
              aria-label="<?= $cta_text ?> about this">
              <?= $cta_text ?>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
