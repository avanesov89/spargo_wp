<?php
/**
 * Схема проезда на странице контактов
 * @var $args
 */
if (have_rows($args['field'])): ?>
  <div class="contacts__scheme-item">
    <?php while ( have_rows($args['field']) ) : the_row(); ?>
      <div class="contacts__scheme-metro">
        <?php theme_svg('icon__metro'); ?>
        <?php echo get_sub_field('title'); ?>
      </div>

      <div class="contacts__scheme-bus">
        <?php echo get_sub_field('transport'); ?>
      </div>

      <div class="contacts__scheme-tooltip">
        <?php echo get_sub_field('nav'); ?>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif;