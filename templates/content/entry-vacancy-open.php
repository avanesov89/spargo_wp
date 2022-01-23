<?php
/**
 * Шаблон открытой вакансии в главном списке вакансий
 */
?>
<a href="<?php  the_permalink(); ?>" title="<?php echo get_the_title(); ?>" <?php post_class('vacancies__open-item'); ?>>
  <?php the_title('<div class="vacancies__open-position">', '</div>'); ?>

  <div class="vacancies__open-salary">
    <?php echo get_field('wages'); ?>
  </div>
  <div class="vacancies__open-city">
    <?php echo get_field('region'); ?>
  </div>
</a>

