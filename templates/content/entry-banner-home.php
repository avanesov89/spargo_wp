<?php
$link_url = get_post_meta(get_the_ID(), 'url', true);
$link_blank = (get_post_meta(get_the_ID(), 'blank', true)) ? 'target="_blank"' : '';
$image_type = get_post_mime_type(get_post_thumbnail_id());
?>
<li <?php post_class('business__list-item'); ?>>
  <a href="<?php echo $link_url; ?>" title="Производителям" class="business__list-link transition" <?php echo $link_blank; ?>>
    <div class="business__list-title">
      <?php
      if ($image_type == 'image/svg+xml') {
        theme_svg(get_the_post_thumbnail_url(), true, ['class' => 'business__list-image']);
      } else {
        the_post_thumbnail('origin', ['class' => 'business__list-image', 'alt' => get_the_title()]);
      }
      ?>
      <!--<img src="img/manufacture_top.png" alt="Производителям" class="business__list-image">-->
      <?php the_title('', ''); ?>
    </div>
    <div class="business__list-content">
      <?php echo apply_filters('the_content', get_the_content(false)); ?>
    </div>
  </a>
</li>
