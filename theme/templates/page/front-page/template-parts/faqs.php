<?php
use WPLite\Utils\CustomFields;

$title = CustomFields::get_field('faqs_title', 'FAQs');
$content = CustomFields::get_field('faqs_content', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.');
$items = CustomFields::get_field('faqs_items');
?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="mb-5 text-center">
          <h2 class="display-5 fw-bold">
            <?= $title ?>
          </h2>

          <?= wpautop($intro) ?>
        </div>

        <?php if (! empty($items)) { ?>
          <div class="accordion">
            <?php foreach ($items as $key => $item) { ?>
              <?php $is_first = 0 === $key ?>
              <div class="accordion-item">
                <div class="accordion-header">
                  <button
                    data-bs-toggle="collapse"
                    data-bs-target="#accordion-item-<?= $key ?>"
                    aria-expanded="<?= $is_first ? 'true' : 'false' ?>"
                    aria-controls="accordion-item-<?= $key ?>"
                    type="button"
                    class="accordion-button <?= ! $is_first ? 'collapsed' : '' ?>">
                    <?= $item['title'] ?>
                  </button>
                </div>
                <div
                  id="accordion-item-<?= $key ?>"
                  class="accordion-collapse collapse <?= $is_first ? 'show' : '' ?>">
                  <div class="accordion-body">
                    <?= wpautop($item['description']) ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
