<?php
/**
 * Шаблон блока поиска в сайдбаре
 */
?>
<div class="news__sidebar-block">
  <div class="news__sidebar-title">
    <?php _e('Поиск материалов'); ?>
  </div>

  <form role="search" method="get" id="sidebar-searchform" action="<?php echo home_url( '/' ) ?>" class="news__sidebar-form">
    <input type="text" placeholder="Введите ключевое слово" class="news__sidebar-input" value="<?php echo get_search_query() ?>" name="s" id="s" />
    <button type="submit" id="sidebar-searchsubmit" class="news__sidebar-button btn-reset">
      <?php theme_svg('search_icon'); ?>
    </button>
  </form>
</div>
