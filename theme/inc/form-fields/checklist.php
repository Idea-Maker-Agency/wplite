<?php if (! $args['hide_label']) { ?>
  <label
    for="<?= $args['id'] ?>"
    class="form-label">
    <?= $args['label'] ?>

    <?php if ($args['required']) { ?>
      <span class="text-danger">*</span>
    <?php } ?>
  </label>
<?php } ?>

<?php
foreach ($args['options'] as $option) {
  $text  = $option['text']  ?? $option;
  $value = $option['value'] ?? $option;

  $id = strtolower(str_replace(' ', '-', $value));
  $id = "{$args['name']}_{$id}";
  ?>
  <div class="form-check">
    <input
      id="id_<?= $id ?>"
      name="<?= $args['name'] ?>[]"
      value="<?= $value ?>"
      type="checkbox"
      class="form-check-input"
      <?= in_array($value, $args['request_value'] ?: $args['value'] ?: []) ? 'checked' : '' ?>>

    <label
      for="id_<?= $id ?>"
      class="form-check-label">
      <?= $text ?>
    </label>

    <?php if (! empty($option['helper_text'])) { ?>
      <div class="form-text">
        <?= $option['helper_text'] ?>
      </div>
    <?php } ?>
  </div>
<?php } ?>
