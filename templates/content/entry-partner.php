<?php
/**
 * Шаблон отображения партнера в архиве
 */
$partner_fields = get_fields();
?>
<div <?php post_class('partners__item'); ?>>
  <div class="partners__name">
    <?php if (has_post_thumbnail()) : ?>
    <div class="partners__img">
      <?php the_post_thumbnail('original', ['class' => 'partners__image', 'alt' => get_the_title()]); ?>
    </div>
    <?php endif; ?>

    <?php the_title('<div class="partners__title partners__title-mobail">', '</div>'); ?>
  </div>
  <div class="partners__content">
    <?php the_title('<div class="partners__title">', '</div>'); ?>

    <div class="partners__contacts">
      <?php
      foreach ($partner_fields as $key => $field) :
        if (!empty($field)) :
          if ($key == 'website') : ?>
            <div class="partners__contacts-item"><?php echo parse_url($field, PHP_URL_HOST); ?></div>
          <?php else : ?>
            <div class="partners__contacts-item"><?php echo $field; ?></div>
          <?php endif;
        endif;
      endforeach;
      ?>
    </div>
  </div>
</div>
