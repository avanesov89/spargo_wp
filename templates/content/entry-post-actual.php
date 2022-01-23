<?php
?>
<article <?php post_class('last__renewal-item last__renewal-item--page'); ?>>
  <time datetime="<?php echo get_the_date('d.m.Y'); ?>" class="last__renewal-date"><?php echo get_the_date('d.m.Y'); ?></time>
  <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e(get_the_title()); ?>" class="last__renewal-title transition">
    <?php the_title(); ?>
  </a>
  <div class="last__renewal-content">
    <?php the_content(false); ?>
  </div>
</article>
