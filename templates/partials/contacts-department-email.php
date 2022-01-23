<?php
/**
 * Email отдела на странице контактов
 * @var $args
 */
if ($field = get_field_object($args['field'])):
  ?>
  <div class="contacts__department-block contacts__department-block--mail">
    <div class="contacts__department-title">
      <?php echo $field['label']; ?>:
    </div>
    <a href="mailto:<?php echo $field['value']; ?>" class="contacts__department-info contacts__department-info--link">
      <?php echo $field['value']; ?>
    </a>
  </div>
<?php
endif;
