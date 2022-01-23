<?php
/**
 * Banners layout "Cover"
 * @var $banners
 * @var $instance
 */
if ($banners) : ?>
  <div class="main__slaider">
    <div class="container">
      <h1 class="main__slaider-title">
        <?php echo $instance['title']; ?>
      </h1>
      <h2 class="main__slaider-description">
        <?php echo $instance['description']; ?>
      </h2>
    </div>

    <div class="main__slaider-list">
      <ul class="business__list list-reset">
        <?php
        do_action('banners_start', ['layout' => 'cover']);

        while ($banners->have_posts()) :
          $banners->the_post();

          get_template_part('templates/content/entry-banner', 'home');
        endwhile;

        do_action('banners_end', ['layout' => 'cover']);
        ?>
      </ul>
    </div>
  </div>
<?php
endif;
