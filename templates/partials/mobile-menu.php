<?php
/**
 * Шаблон меню для мобильных устройств
 */
?>
<div class="a-menu">
  <div class="a-menu__title">
    <?php _e('Навигация'); ?>
    <div class="close-trigger">
      <?php theme_svg('icon_close'); ?>
    </div>
  </div>

  <?php
  wp_nav_menu([
    'container' => 'nav',
    'container_class' => false,
    'theme_location' => 'mobile',
    'menu_class' => 'menu',
  ]);
  ?>
</div>
