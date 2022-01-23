<?php
/**
 * Шаблон записи в результатах поиска
 */
$taxes = get_taxonomies();
$nosearch_taxes = ['post_tag', 'nav_menu', 'post_format', 'wp_theme', 'dev_tag'];
foreach ($taxes as $tax) {
  if (!in_array($tax, $nosearch_taxes)) {
    $tax_array[] = $tax;
  }
}
if (!empty($tax_array)) {
  $terms = wp_get_post_terms( get_the_ID(), $tax_array);
}

?>
<article <?php post_class('blog__item'); ?>>
  <div class="blog__item-content">
    <h3 class="blog__item-title">
      <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e(get_the_title()); ?>" class="blog__item-title--link transition">
        <?php echo get_the_title(); ?>
      </a>
    </h3>
    <div class="blog__item-text">
      <?php the_excerpt(); ?>
    </div>
    <div class="blog__item-bottom">
      <div class="news__element-detail">
        <?php foreach ($terms as $term) : ?>
          <div class="news__element-item">
            <a href="<?php echo get_term_link($term->term_id); ?>" title="<?php echo $term->name; ?>" class="blog__item-link transition">
              <?php echo $term->name; ?>
            </a>
          </div>
        <?php endforeach; ?>
        <time class="news__element-item news__element-date">
          <?php echo get_the_date('d.m.Y'); ?>
        </time>
        <div class="news__element-item">
          <?php echo do_shortcode('[post-views]'); ?>
        </div>
      </div>
      <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e(get_the_title()); ?>" class="blog__item-link transition">
        <?php
        _e('Читать дальше');
        theme_svg('arrow__right');
        ?>
      </a>
    </div>
  </div>
</article>
