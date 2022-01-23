<?php

/**
 * The template for displaying archive documents posts
 *
 * @link https://github.com/avanesov89/spargodev/blob/master/src/partials/documents.html
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_header();



$documents_title = (!empty(theme_option('documents_main_title'))) ? theme_option('documents_main_title') : get_the_archive_title();
do_action('breadcrumbs', ['title' => $documents_title]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content">
          <h1><?php echo $documents_title; ?></h1>

          <?php if (!empty($documents_description = theme_option('documents_main_description'))) : ?>
            <?php echo apply_filters('the_content', $documents_description); ?>
          <?php endif; ?>

          <ul class="documents list-reset">
            <?php
            // Start the Loop.
            while (have_posts()) :
              the_post();

              get_template_part('templates/content/entry', 'document');
            endwhile;
            ?>
          </ul>

        </div>
      </div>
    </div>
  </div>
<?php
get_footer();