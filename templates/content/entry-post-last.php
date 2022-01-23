<?php
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'original');

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
<div <?php post_class('news__last-block'); ?>>
  <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e(get_the_title()); ?>" class="news__last-item transition"
     <?php if (!empty($thumbnail_url)): ?>style="background-image: url(<?php esc_attr_e($thumbnail_url); ?>);"<?php endif; ?>>
    <div class="news__last-prompt">
      <?php echo $current_category->name; ?>
    </div>
    <?php the_title('<div class="news__last-title">', '</div>'); ?>

    <div class="news__last-date">
      <?php echo get_the_date('d.m.Y'); ?>
    </div>
  </a>
</div>
