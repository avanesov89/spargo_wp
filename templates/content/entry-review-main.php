<?php
$author_logo = get_field('author_logo');
$author_position = get_field('author_position');
?>
<div <?php post_class('reviews__item'); ?>>
  <div class="reviews__item-top">
    <?php if ($author_logo) : ?>
      <div class="reviews__img">
        <img src="<?php echo wp_get_attachment_url($author_logo); ?>" alt="<?php esc_attr_e(get_the_title()); ?>" class="reviews__image">
      </div>
    <?php endif; ?>
    <div class="reviews__name">
      <?php if ($author_logo ) : ?>
        <div class="reviews__img reviews__name-img">
          <img src="<?php echo wp_get_attachment_url($author_logo); ?>" alt="<?php esc_attr_e(get_the_title()); ?>" class="reviews__image">
        </div>
      <?php endif; ?>
      <?php the_title(); ?>
      <?php if ($author_logo ) : ?>
      <div class="reviews__name-office"><?php echo $author_position; ?></div>
      <?php endif; ?>
    </div>
  </div>
  <div class="reviews__content">
    <div class="reviews__text">
      <?php echo strip_tags(get_the_content(false)); ?>
    </div>

    <?php if (has_post_thumbnail()) : ?>
    <a class="reviews__link" href="<?php the_post_thumbnail_url('original'); ?>" data-fancybox>
      <?php _e('Отзыв на фирменном бланке компании'); ?>
    </a>
    <?php endif; ?>
  </div>
</div>
