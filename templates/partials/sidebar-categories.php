<?php
/**
 * Шаблон отображения дочерних категорий рубрики
 * @var $args
 */
$tax_type = ( !empty($args['tax_type']) ) ? $args['tax_type'] : 'category';
$term_id = get_queried_object_id();

if ($term_id > 0) {
  $current_category = get_term($term_id, $tax_type);

  if ($current_category->parent > 0) {
    $children_ids = get_term_children($current_category->parent, $tax_type);
  } else {
    $children_ids = get_term_children($term_id, $tax_type);
  }
}

$childs = false;

if (!empty($children_ids)) {
  $childs = get_categories(['taxonomy' => $tax_type, 'include' => $children_ids, 'hide_empty' => false]);
} else {
  $childs = get_terms(['taxonomy' => $tax_type, 'hide_empty' => false]);
}

if ($childs):
?>
<div class="news__sidebar-block">
  <div class="news__sidebar-title">
    <?php _e('Рубрики материалов'); ?>
  </div>
  <nav class="wrapper__sidebar-nav">
    <ul class="wrapper__sidebar-menu list-reset">
      <?php foreach ($childs as $child) : ?>
        <?php if ($term_id == $child->term_id) : ?>
          <li class="wrapper__sidebar-list wrapper__sidebar-list--active">
            <span class="wrapper__sidebar-span">
              <?php echo $child->name; ?>
              <div class="news__sidebar-counter"><?php echo $child->count; ?></div>
            </span>
          </li>
        <?php else: ?>
          <li class="wrapper__sidebar-list">
            <a href="<?php echo get_category_link($child->term_id); ?>" class="wrapper__sidebar-link" title="<?php esc_attr_e($child->name); ?>">
              <?php echo $child->name; ?>
              <div class="news__sidebar-counter"><?php echo $child->count; ?></div>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </nav>
</div>
<?php
endif;