<?php
/**
 * Телфон отдела на странице контактов (простой)
 * @var $args
 */
if ($field = get_field_object($args['field'])):
  ?>
  <div class="contacts__department-block contacts__department-block--phone">
    <div class="contacts__department-title">
      <?php echo $field['label']; ?>:
    </div>
    <a href="tel:<?php echo preg_replace('/[^0-9\+]/', '', $field['value']); ?>" class="contacts__department-info contacts__department-info--link">
      <?php echo preg_replace('/,/', '<br/>', $field['value']); ?>
    </a>
  </div>
<?php
endif;