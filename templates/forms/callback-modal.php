<?php
/**
 * Шаблон модального окна формы для заявки на партнерство
 */
if ($form_id = theme_option('callback_form')) :
  $form = get_post(theme_option('callback_form'));
  ?>
  <div class="hystmodal hystmodal--simple modal-callback" aria-hidden="true">
    <div class="hystmodal__wrap">
      <div class="hystmodal__window hystmodal__window--form" role="dialog" aria-modal="true">
        <div class="modal">
          <button class="hystmodal__close" type="button" aria-label="Закрыть окно" data-hystclose>
            <?php theme_svg('icon_close'); ?>
          </button>
          <h3 class="hystmodal__title">
            <?php echo $form->post_title; ?>
          </h3>
          <p class="hystmodal__subtitle">
            <?php _e('Мы перезвоним в самое ближайшее время.'); ?>
          </p>

          <?php echo do_shortcode('[contact-form-7 id="' . $form->ID . '" html_class="hystmodal__form main__form"]'); ?>
        </div>
      </div>
    </div>
  </div>
  <?php
endif;