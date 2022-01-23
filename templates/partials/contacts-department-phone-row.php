<?php
/**
 * Телфон отдела на странице контактов (простой)
 * @var $args
 */
if ($field = get_field_object($args['field'])):
  ?>
  <div class="contacts__department-block contacts__department-block--phone">
    <div class="contacts__department-title">
      <?php echo (!empty($args['title'])) ? $args['title'] : $field['label']; ?>:
    </div>
    <?php
    while ( have_rows($field['name']) ) :
      the_row();
      if (get_sub_field('number')) : ?>
        <a href="tel:<?php echo preg_replace('/[^0-9\+]/', '', get_sub_field('number')); ?>" class="contacts__department-info contacts__department-info--link">
          <?php echo get_sub_field('number'); ?>
        </a>
      <?php
      endif;
      if (get_sub_field('hint')) : ?>
        <span class="contacts__department-tooltip"><?php echo get_sub_field('hint'); ?></span>
      <?php endif;
    endwhile; ?>
  </div>
<?php
endif;
