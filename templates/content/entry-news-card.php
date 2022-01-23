<?php
/**
 * News item layout "Card"
 */
$tags = wp_get_post_tags( get_the_ID() );

foreach ($tags as $tag) {
  if (empty($tag_tax)) {
    $tag_tax = $tag;
  } else {
    if ($tag->count > $tag_tax->count) {
      $tag_tax = $tag;
    }
  }
}
?>
<article <?php post_class('news__item'); ?>>
  <?php if (!empty( $tag_tax )) : ?>
  <div class="news__item-prompt"><?php echo ucfirst($tag_tax->name); ?></div>
  <?php endif; ?>

  <div class="news__item-img">
    <?php the_post_thumbnail('original', ['class' => 'news__item-image', 'alt' => esc_attr(get_the_title())]); ?>
  </div>

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