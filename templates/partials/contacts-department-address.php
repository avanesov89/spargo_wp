<?php
/**
 * Адрес отдела на странице контактов
 * @var $args
 */
if ($field = get_field_object($args['field'])):
  ?>
  <div class="contacts__department-block contacts__department-block--address">
    <div class="contacts__department-title">
      <?php echo $field['label']; ?>:
    </div>
    <span class="contacts__department-info"><?php echo $field['value']; ?></span>
  </div>
<?php
endif;
