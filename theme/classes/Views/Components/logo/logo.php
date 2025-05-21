<?php
$default_args = [];

extract(wp_parse_args($args, $default_args));

$site_name = get_bloginfo('name');
?>
<a
  href="<?= site_url() ?>"
  class="<?= $link_class ?? '' ?>">
  <?php if ($logo_url = get_theme_mod('wplite_branding_logo')) { ?>
    <img
      src="<?= $logo_url ?>"
      alt="<?= $site_name ?>"
      width="<?= $width   ?? 100 ?>"
      height="<?= $height ?? 36 ?>">
  <?php } else { ?>
    <?= $site_name ?>
  <?php } ?>
</a>

