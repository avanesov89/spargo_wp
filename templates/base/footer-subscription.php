<?php
/**
 * Шаблон подписки на рассылку в подвале сайта
 * @var $args
 */
?>
<div class="footer__block footer__block-subscription">
  <div class="footer__block-title"><?php _e('Подписка на новости'); ?></div>

  <div class="footer__subscription">
    <div class="footer__subscription-text">
      <?php _e('Для получения актуальных новостей, отчетов и специальных предложениях'); ?>
    </div>

    <?php echo strip_tags(do_shortcode('[contact-form-7 id="'. $args['cf7_form'] .'" html_class="footer__subscription-form"]'), ['span', 'div', 'input']); ?>

    <span class="footer__subscription-licenze">
      <?php _e('Отправляя адрес своей электронной почты, вы автоматически соглашаетесь с условиями'); ?>
      <a href="#" title="<?php _e('Условия обработки данных'); ?>" class="footer__subscription-link"><?php _e('обработки персональных данных'); ?></a></span>
  </div>
</div>
