<?php
/**
 * Шаблон модального окна формы для заявки на партнерство
 * @var $args
 */
$form = get_post($args['form_id']);
?>
<div class="hystmodal hystmodal--simple modal-partners" aria-hidden="true">
  <div class="hystmodal__wrap">
    <div class="hystmodal__window hystmodal__window--form" role="dialog" aria-modal="true">
      <div class="modal">
        <button class="hystmodal__close" type="button" aria-label="Закрыть окно" data-hystclose>
          <?php theme_svg('icon_close'); ?>
        </button>
        <h3 class="hystmodal__title">
          <?php echo $form->post_title; ?>
        </h3>

        <?php echo do_shortcode('[contact-form-7 id="' . $form->ID . '"]'); ?>
      </div>
    </div>
  </div>
</div>