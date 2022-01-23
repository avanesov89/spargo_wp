<?php
/**
 * Навиация на странице "О компании"
 */
$nav_items = get_field('nav_links');
$nav_icons = [
  'document'  => 'about_all_1',
  'vacancy'   => 'about_all_2',
  'review'    => 'about_all_3',
  'partner'   => 'about_all_4',
];
$nav_title = get_field('nav_title');

if (!empty($nav_items)) :
?>
<div class="about__all scrollableList">
  <div class="scrollableList__title">
    <?php echo ($nav_title) ? $nav_title : __('Еще больше о нас'); ?>
  </div>

  <div class="scrollableList__items">
    <?php foreach ($nav_items as $item) : ?>
      <div class="scrollableList__block about__all-block">
        <a href="<?php echo get_post_type_archive_link($item['value']); ?>" class="about__all-item" title="<?php esc_attr_e($item['label']); ?>">
          <div class="about__all-img">
            <?php theme_svg($nav_icons[$item['value']]); ?>
          </div>
          <div class="about__all-title">
            <?php echo $item['label']; ?>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif;