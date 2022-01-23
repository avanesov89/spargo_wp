<?php
/**
 * Шаблон элемента записи в архиве продуктов
 */
?>
<div id="app-<?php the_ID(); ?>" <?php post_class('app__list-block'); ?>>
  <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>" class="app__item-link">
    <div class="app__item-top">
      <?php if (has_post_thumbnail()) : ?>
        <div class="app__item-img">
          <?php the_post_thumbnail('big', ['class' => 'app__item-image', 'alt' => get_the_title()]); ?>
        </div>
      <?php endif; ?>
      <?php $title = preg_split('/-|&#8212;/', get_the_title());?>
      <div class="app__item-title">
        <?php echo trim($title[0]); ?>
        <?php if (count($title) > 0) :
          unset($title[0]);
          sort($title);
          $subtitle = implode(' ', $title);
          ?>
          <span><?php echo trim($subtitle); ?></span>
        <?php endif; ?>
      </div>
    </div>
    <div class="app__item-content">
      <?php the_excerpt(); ?>
    </div>
  </a>
</div>
