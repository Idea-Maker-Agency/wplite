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

<select <?= implode(' ', $args['attrs']) ?>>
  <option
    value=""
    <?= selected($args['request_value'] ?? $args['value'], '') ?>>
    <?= __('Select option', THEME_TEXT_DOMAIN) ?>
  </option>

  <?php
  foreach ($args['options'] as $option) {
    $text = $option['text'] ?? $option;
    $value = $option['value'] ?? $option;
  ?>
    <option
      value="<?= $value ?>"
      <?= selected($args['request_value'] ?? $args['value'], $value) ?>>
      <?= __($text, THEME_TEXT_DOMAIN) ?>
    </option>
  <?php } ?>
</select>
