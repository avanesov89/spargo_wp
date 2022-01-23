<?php
/**
 * Banners layout "Cover"
 * @var $reviews
 * @var $instance
 * @var $args
 */
?>
<div class="reviews__main">
  <div class="container">
    <div class="row">
      <div class="main__title">
        <?php echo $instance['title']; ?>
        <div class="main__title-span">
          <?php echo $instance['description']; ?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="reviews__main-list">
        <?php
        while ($reviews->have_posts()) :
          $reviews->the_post();

          get_template_part('templates/content/entry-review', 'main');
        endwhile;
        ?>
      </div>
    </div>

    <div class="row">
      <a href="<?php echo get_post_type_archive_link('review'); ?>" title="<?php _e('Все отзывы'); ?>" class="main__button btn-reset">
        <?php _e('Все отзывы'); ?>
      </a>
    </div>

  </div>
</div>