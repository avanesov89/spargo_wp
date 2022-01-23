<?php
/**
 * The template for displaying archive dev blog posts
 *
 * @link https://github.com/avanesov89/spargodev/blob/master/src/partials/documents.html
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_header();
// Хлебные крошки
do_action('breadcrumbs', ['title' => __('Технический блог')]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content wrapper__content-75 text__block">
          <div class="blog__items">
            <?php
            // Start the Loop.
            while (have_posts()) :
              the_post();

              get_template_part('templates/content/entry-post', 'dev');
            endwhile;
            ?>
          </div>
        </div>

        <div class="wrapper__sidebar">
          <div class="wrapper__sidebar-sticky news__sidebar">
            <?php get_template_part('templates/partials/sidebar', 'search'); ?>

            <?php get_template_part('templates/partials/sidebar', 'categories', ['tax_type' => 'dev_category']); ?>

            <?php get_template_part('templates/partials/sidebar', 'tags', ['tag_type' => 'dev_tag']); ?>

            <?php get_template_part('templates/partials/sidebar', 'social'); ?>
          </div>
        </div>
      </div>
    </div>

    <?php // Пагинация ?>
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
