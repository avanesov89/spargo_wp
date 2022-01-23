<?php
/**
 * Шаблон модального окна формы заказа услуги
 * @var $args
 */
$form = get_post($args['form_id']);
?>
<div class="hystmodal hystmodal--simple modal-services" aria-hidden="true">
  <div class="hystmodal__wrap">
    <div class="hystmodal__window hystmodal__window--form" role="dialog" aria-modal="true">
      <div class="modal">
        <button class="hystmodal__close" type="button" aria-label="Закрыть окно" data-hystclose>
          <?php theme_svg('icon_close'); ?>
        </button>
        <h3 class="hystmodal__title">
          <?php echo $form->post_title; ?>
        </h3>

        <?php echo do_shortcode('[contact-form-7 id="' . $form->ID . '" html_class="hystmodal__form main__form"]'); ?>
      </div>
    </div>
  </div>
</div>