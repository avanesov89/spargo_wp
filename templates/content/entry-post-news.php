<?php
/**
 * Шаблон отображения новости в категории новостей
 */
$categories = get_the_category();
if (count($categories) > 1) {
  foreach ($categories as $category) {
    if ($category->parent > 0) {
      $current_category = $category;
    }
  }
} else {
  $current_category = $categories[0];
}
?>
<article <?php post_class('news__item'); ?>>
  <div class="news__item-prompt"><?php echo $current_category->name; ?></div>

  <?php if ( has_post_thumbnail() ): ?>
    <div class="news__item-img">
      <?php the_post_thumbnail('original', ['class' => 'news__item-image', 'alt' => esc_attr(get_the_title())]); ?>
    </div>
  <?php endif; ?>

  <div class="news__item-content">
    <?php the_title('<h3 class="news__item-title"><a href="'. get_the_permalink() . '" class="news__item-title--link transition">', '</a></h3>'); ?>

    <div class="news__item-text">
      <?php echo strip_tags(get_the_content('...')); ?>
    </div>
    <div class="news__item-details">
      <div class="news__item-date">
        <?php echo get_the_date('d.m.Y'); ?>
      </div>
      <a href="<?php the_permalink(); ?>" class="news__item-more transition">
        <?php
        _e('Читать дальше');
        theme_svg('arrow__right');
        ?>
      </a>
    </div>
  </div>
</article>
