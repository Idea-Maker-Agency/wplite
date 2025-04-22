# Group

Registers a group of custom fields.

## Register field

```yaml
- group: "Section 1"
  fields:
    - name: "section_1_cta_primary"
      type: "group"
      label: "Primary CTA Button"
      fields:
        - name: "text"
          type: "text"
          label: "Text"
          width: 50

        - name: "url"
          type: "url"
          label: "URL"
          width: 50
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$cta_primary_text = CustomFields::get_field('section_1_cta_primary_text');
$cta_primary_url = CustomFields::get_field('section_1_cta_primary_url');

<?php if ($cta_primary_url) { ?>
  <a
    href="<?= $cta_primary_url ?>"
    class="btn btn-primary"
    rel="nofollow noopener noreferrer"
    alt="<?= $cta_primary_text ?>"
    aria-label="<?= $cta_primary_text ?>" >
    <?= $cta_primary_text ?>
  </a>
<?php }
```
