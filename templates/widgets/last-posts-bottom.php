<?php
/**
 * Виджет вывода последних статей после содержимого страницы записи
 * @var $args
 */
$query_args['posts_per_page'] = 4;

if ($args['term_id']) {
  $query_args['tax_query'] = [
    'relation'        => 'AND',
    [
      'taxonomy'      => 'category',
      'field'         => 'term_id',
      'terms'         => absint($args['term_id']),
    ],
  ];
}
$last_posts = new WP_Query($query_args);

if ($last_posts->have_posts()): ?>
  <div class="container">
    <div class="row">
      <div class="news__last scrollableList">
        <div class="scrollableList__title">
          <?php _e('Последние материалы'); ?>
        </div>
        <div class="scrollableList__items">
          <?php
          while ($last_posts->have_posts()) :
            $last_posts->the_post();

            get_template_part('templates/content/entry-post', 'last');
          endwhile;
          ?>
        </div>
      </div>
    </div>
  </div>
<?php
wp_reset_query();
endif;
