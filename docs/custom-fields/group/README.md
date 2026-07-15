# Group

Registers a group of custom fields.

## Register field

```yaml
my_page:
    group: "Section 1"
    fields:
        section_1_cta_primary:
            type: group
            label: "Primary CTA Button"
            fields:
                text:
                    type: text
                    label: "Text"
                    width: 50

                url:
                    type: url
                    label: "URL"
                    width: 50
```

## Usage

```phtml
<?php
$cta_primary_text = wplite_cf_value('section_1_cta_primary_text');
$cta_primary_url = wplite_cf_value('section_1_cta_primary_url');

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
