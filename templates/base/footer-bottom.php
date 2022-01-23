<?php
/**
 * Шаблон нижней части подвала сайта
 */
$personal_data_page_id = absint(theme_option('personal_data_page'));
?>
<div class="footer__bottom">
  <div class="container">
    <span>&copy; <?php echo theme_option('copyright_start_year') . '-' . date('Y') . ' ' . theme_option('copyright_sign'); ?></span>
    <?php if ($personal_data_page_id > 0) : ?>
    <a href="<?php echo get_permalink($personal_data_page_id) ?>" title="<?php echo get_the_title($personal_data_page_id) ?>" class="footer__bottom-link">
      <?php echo get_the_title($personal_data_page_id) ?>
    </a>
    <?php endif; ?>
  </div>
</div>
