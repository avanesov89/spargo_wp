<?php

/**
 * The template for displaying archive reviews posts
 *
 * @link https://github.com/avanesov89/spargodev/blob/master/src/partials/reviews.html
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_header();



$reviews_title = (!empty(theme_option('reviews_main_title'))) ? theme_option('reviews_main_title') : get_the_archive_title();
do_action('breadcrumbs', ['title' => $reviews_title]);
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block">
        <?php if (!empty($reviews_description = theme_option('reviews_main_description'))) : ?>
          <?php echo apply_filters('the_content', $reviews_description); ?>
        <?php endif; ?>

        <div class="reviews__list">
          <?php
          // Start the Loop.
          while (have_posts()) :
            the_post();

            get_template_part('templates/content/entry-review', 'list');
          endwhile;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <?php
      $pagination = paginate_links([
        'type'      => 'array',
        'prev_text' => __('Ранее'),
        'next_text' => __('Далее'),
      ]);
      get_template_part('templates/partials/pagination', null, $pagination);
      ?>
    </div>
  </div>
</div>
<?php
get_footer();
