<button
  class="navbar-toggler"
  type="button"
  data-bs-toggle="collapse"
  data-bs-target="#header-menu"
  aria-controls="header-menu"
  aria-expanded="false"
  aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div
  id="header-menu"
  class="collapse navbar-collapse">
  <?php wp_nav_menu([
    'menu' => 'header-menu',
    'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
    'container' => '',
    'fallback_cb' => false,
  ]) ?>
</div>
