<?php
/**
 * Шаблон услуги в списке услуг
 */
?>
<div <?php post_class('services__item-block'); ?>>
  <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e(get_the_title()); ?>" class="services__item-link">
    <div class="services__item-title">
      <?php if (has_post_thumbnail()) : ?>
        <div class="services__item-img">
          <?php theme_svg(get_the_post_thumbnail_url(), true, ['class' => 'services__item-image']); ?>
        </div>
      <?php endif; ?>

      <?php the_title(); ?>
    </div>

    <div class="services__item-description">
      <?php the_excerpt(); ?>
    </div>
    <div class="services__item-more">
      <?php _e('Подробнее'); ?>

      <?php theme_svg('icon_more'); ?>
    </div>
  </a>
</div>
