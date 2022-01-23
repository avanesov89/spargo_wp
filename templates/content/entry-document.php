<?php
/**
 * Шаблон отображения документа в архиве
 */
?>
<li <?php post_class('documents__item'); ?>>
  <a class="documents__img" href="<?php esc_attr_e( get_the_post_thumbnail_url(get_the_ID(), 'original') ); ?>" data-fancybox="gallery">
    <?php the_post_thumbnail('original', ['class' => 'documents__image']); ?>

    <div class="documents__hover">
      <?php theme_svg('icon_magnifier'); ?>

      <?php theme_svg('icon_download'); ?>
    </div>
  </a>

  <?php the_title('<div class="documents__title">', '</div>'); ?>
</li>
