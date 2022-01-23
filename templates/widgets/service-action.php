<?php
/**
 * Шаблон виджета "Закаать услугу" в боковой колонке страницы услуги
 * @var $args
 */
if ($args['form_id']) :
?>
  <div class="wrapper__sidebar-action">
    <div class="wrapper__sidebar-title">
      <?php _e('Заказать услугу'); ?>
    </div>

    <?php if ($args['description']) : ?>
      <div class="wrapper__sidebar-text">
        <?php echo $args['description']; ?>
      </div>
    <?php endif; ?>

    <button class="main__button btn-reset" data-hystmodal=".modal-services">
      <?php echo ($args['btn']) ? $args['btn'] : __('Условия внедрения'); ?>
    </button>
  </div>
<?php
endif;