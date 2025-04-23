<?php
use WPLite\Utils\CustomFields;

$title = CustomFields::get_field('features_title', 'Features');
$intro = CustomFields::get_field('features_intro', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.');
$items = CustomFields::get_field('features_items');
?>

<section class="bg-light py-5">
  <div class="container">
    <div class="mb-5 text-center">
      <h2 class="display-5 fw-bold">
        <?= $title ?>
      </h2>

      <?= wpautop($intro) ?>
    </div>

    <?php if (! empty($items)) { ?>
      <div class="row row-cols-1 row-cols-lg-3 g-4">
        <?php foreach ($items as $item) { ?>
          <div class="feature col">
            <?php if ($itemd_image_id = $item['featured_image']) { ?>
              <img
                src="<?= wp_get_attachment_image_url($itemd_image_id, [75, 75]) ?>"
                width="75"
                height="75"
                alt="Alt text"
                decoding="async"
                class="feature__icon img-fluid mb-2" />
            <?php } ?>

            <h3 class="feature__heading fw-bold">
              <?= $item['title'] ?>
            </h3>

            <?= wpautop($item['content']) ?>

            <a
              href="<?= esc_url($item['url']) ?: '#' ?>"
              class="feature__link text-decoration-none fw-bold"
              rel="noopener noreferrer"
              alt="<?= __('Read more', THEME_TEXT_DOMAIN) ?>"
              aria-label="<?= __('Read more', THEME_TEXT_DOMAIN) ?> about Lorem ipsum" >
              <?= __('Read more', THEME_TEXT_DOMAIN) ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>
            </a>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</section>
