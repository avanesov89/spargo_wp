<?php
/**
 * The template for displaying archive posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_header();

do_action('breadcrumbs', ['title' => get_the_archive_title()]);
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content wrapper__content-75 text__block">

        <div class="news__items">
          <?php
          // Start the Loop.
          while (have_posts()) :
            the_post();

            get_template_part('templates/content/entry-post', 'news');
          endwhile;
          ?>
        </div>

      </div>

      <div class="wrapper__sidebar">
        <div class="wrapper__sidebar-sticky news__sidebar">
          <?php get_template_part('templates/partials/sidebar', 'search'); ?>

          <?php get_template_part('templates/partials/sidebar', 'categories'); ?>

          <?php get_template_part('templates/partials/sidebar', 'tags'); ?>

          <?php get_template_part('templates/partials/sidebar', 'social'); ?>
        </div>
      </div>

    </div>
  </div>

  <div class="container">
    <div class="row">
      <?php
      $pagintion = paginate_links([
          'type'      => 'array',
          'prev_text' => __('Ранее'),
          'next_text' => __('Далее'),
      ]);
      get_template_part('templates/partials/pagination', null, $pagintion);
      ?>
    </div>
  </div>
</div>
<?php
get_footer();
