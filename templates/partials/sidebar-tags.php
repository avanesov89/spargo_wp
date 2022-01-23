<?php
/**
 * Шаблон отображения блока тегов в сайдбаре категории
 * @var $args
 */

$tag_type = ( !empty($args['tag_type']) ) ? $args['tag_type'] : 'post_tag';

switch ($tag_type) {
  case 'dev_tag':
    $cat_terms = get_terms(['taxonomy' => 'dev_category', 'hide_empty' => true]);
    foreach ($cat_terms as $cat_term) {
      $cat_terms_ids[] = $cat_term->term_id;
    }

    $post_ids = get_objects_in_term( $cat_terms_ids, 'dev_category' );

    if (!empty($post_ids) && !is_wp_error($post_ids)) {
      $tags = wp_get_object_terms( $post_ids, 'dev_tag' );
    }
    break;

  default:
    $current_cat = get_query_var( 'cat' );

    $kids = get_terms([
      'taxonomy' => get_queried_object()->taxonomy,
      'parent'   => $current_cat,
    ]);

    $cats = [$current_cat];

    if (!empty($kids)) {
      foreach ($kids as $kid) {
        $cats[] = $kid->term_id;
      }
    }

    $post_ids = get_objects_in_term( $cats, 'category' );

    if (!empty($post_ids) && !is_wp_error($post_ids)) {
      foreach ($post_ids as $id) {
        $ids[] = absint($id);
      }

      $tags = wp_get_object_terms( $ids, 'post_tag' );
    }
    break;
}


if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
  <div class="news__sidebar-block">
    <div class="news__sidebar-title">
      <?php _e('Теги'); ?>
    </div>
    <div class="tags">
      <?php foreach ($tags as $tag) : ?>
        <a href="<?php echo get_term_link( $tag, 'post_tag' ); ?>" title="<?php echo $tag->name; ?>" class="tags__item transition">
          <?php echo $tag->name; ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
<?php
endif;
