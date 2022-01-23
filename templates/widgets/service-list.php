<?php
/**
 * Список других услуг в боковой колонке странице услуги
 * @var $args;
 */
$query = new WP_Query([
  'post_type'         => 'service',
  'nopaging'          => true,
  'orderby'           => 'menu_item',
  'order'             =>  'ASC',
]);

if ($query->have_posts()) :
?>
  <div class="wrapper__sidebar-all">
    <div class="wrapper__sidebar-title">
      <?php _e('Другие услуги'); ?>
    </div>
    <nav class="wrapper__sidebar-nav">
      <ul class="wrapper__sidebar-menu list-reset">
        <?php while ($query->have_posts()) :
          $query->the_post();

          if (get_the_ID() == $args['active_id']) :
        ?>
            <li <?php post_class('wrapper__sidebar-list wrapper__sidebar-list--active');?>>
              <span class="wrapper__sidebar-span">
                <?php the_title(); ?>
                <?php theme_svg('sidebar_link'); ?>
              </span>
            </li>
        <?php else: ?>
            <li <?php post_class('wrapper__sidebar-list');?>>
              <a href="<?php get_permalink(); ?>" class="wrapper__sidebar-link" title="<?php echo get_the_title(); ?>">
                <?php the_title(); ?>
                <?php theme_svg('sidebar_link'); ?>
              </a>
            </li>
        <?php
          endif;
        endwhile;
        ?>
      </ul>
    </nav>
  </div>
<?php
endif;