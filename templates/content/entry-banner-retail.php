<?php
$link_url = get_post_meta(get_the_ID(), 'url', true);
$link_blank = (get_post_meta(get_the_ID(), 'blank', true)) ? 'target="_blank"' : '';
?>
<div>
  <div <?php post_class('retail__all-item'); ?>>
    <?php the_post_thumbnail('origin', ['class' => 'retail__all-image', 'alt' => esc_attr(get_the_title())]); ?>
  </div>
</div>

