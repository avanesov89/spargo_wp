<?php
/**
 * Шаблон меню в повале сайта
 * @var $args - параметры, передаваемые при вызове шаблона
 */
$menu = $args['menu'];
if (!empty($menu)): ?>
  <div class="footer__block">
    <div class="footer__block-title"><?php echo wp_get_nav_menu_name($menu); ?></div>
    <?php
    wp_nav_menu([
      'container' => 'nav',
      'container_class' => 'footer__nav',
      'theme_location' => $menu,
      'menu_class' => 'footer__list list-reset',
    ]);
    ?>
  </div>
<?php endif;