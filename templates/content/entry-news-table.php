<div <?php post_class('last__renewal-item'); ?>>
  <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>" class="last__renewal-title transition">
    <?php echo get_the_title(); ?>
  </a>
  <time datetime="<?php echo get_the_date('d.m.Y'); ?>" class="last__renewal-date"><?php echo get_the_date('d.m.Y'); ?></time>
  <div class="last__renewal-content">
    <?php echo strip_tags(get_the_content(false)); ?>
  </div>
</div>