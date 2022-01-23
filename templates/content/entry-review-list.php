<?php
/**
 * Шаблон отображения отзыва в архиве
 */
?>
<div <?php post_class('reviews__item'); ?>>
  <div class="reviews__img">
    <?php
    $review_logo = get_field('author_logo');
    if (absint($review_logo) > 0) :
      $review_logo_img = wp_get_attachment_image(absint($review_logo), 'original', false, ['class' => 'reviews__image']);
      echo $review_logo_img;
    endif;
    ?>
  </div>
  <div class="reviews__content">
    <div class="reviews__text">
      <?php echo apply_filters('the_content', get_the_content(false)); ?>
    </div>
    <div class="reviews__name">
      <div class="reviews__img reviews__name-img">
        <?php
        if ($review_logo_img) :
          echo $review_logo_img;
        endif;
        ?>
      </div>
      <?php the_title(); ?>

      <?php if ($author_position = get_field('author_position')) : ?>
        <div class="reviews__name-office">
        <?php esc_html_e($author_position); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if ( has_post_thumbnail() ): ?>
      <a class="reviews__link" href="<?php esc_attr_e( get_the_post_thumbnail_url(get_the_ID(), 'original') ); ?>" data-fancybox>
        <?php _e('Отзыв на фирменном бланке компании'); ?>
      </a>
    <?php endif; ?>
  </div>
</div>
