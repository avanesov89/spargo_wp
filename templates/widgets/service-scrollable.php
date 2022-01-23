<?php
/**
 * Список других услуг в боковой колонке странице услуги
 */
$query = new WP_Query([
  'post_type'         => 'service',
  'nopaging'          => true,
  'orderby'           => 'menu_item',
  'order'             =>  'ASC',
]);

if ($query->have_posts()) :
  ?>
  <div class="scrollableList">
    <div class="scrollableList__title">
      <?php _e('Другие услуги'); ?>
    </div>
  <div class="scrollableList__items">
    <?php
    while ($query->have_posts()) :
      $query->the_post();
      ?>
      <a href="<?php get_permalink(); ?>" <?php post_class('scrollableList__item');?> title="<?php echo get_the_title(); ?>">
        <div class="scrollableList__item-img">
          <?php
          the_post_thumbnail('original', ['class' => 'services__item-image', 'alt' => get_the_title()]);
          ?>
        </div>
        <?php the_title('<div class="scrollableList__item-title">', '</div>'); ?>

        <div class="scrollableList__item-description">
          <?php the_excerpt(); ?>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
<?php
endif;