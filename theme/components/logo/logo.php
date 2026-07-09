<?php
$args = wp_parse_args($args, [
  'link_class' => 'navbar-brand',
]);

$site_name = get_bloginfo('name');
?>
<a
  href="<?= site_url() ?>"
  class="<?= $args['link_class'] ?? '' ?>">
  <?php if ($logo_url = get_theme_mod('wplite_branding_logo')) { ?>
    <img
      src="<?= $logo_url ?>"
      alt="<?= $site_name ?>"
      width="<?= $args['width']   ?? 100 ?>"
      height="<?= $args['height'] ?? 36 ?>">
  <?php } else { ?>
    <?= $site_name ?>
  <?php } ?>
</a>

