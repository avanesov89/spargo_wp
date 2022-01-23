<?php
/**
 * Заголовок отдела на странице контактов
 * @var $args
 */
if (get_field($args['field'])):
?>
  <div class="contacts__department-division">
    <?php echo get_field($args['field']); ?>
  </div>
<?php
endif;