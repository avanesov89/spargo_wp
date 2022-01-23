<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

do_action('count_post_views');

do_action('breadcrumbs', ['title' => Theme_Posts_Vacancy::get_option('title_main')]);
?>
<div class="wrapper">
  <div class="container">
    <?php

    /* Start the Loop */
    while (have_posts()) :
      the_post();

      get_template_part('templates/content/entry-vacancy', 'single');

    endwhile; // End of the loop.
    ?>
  </div>
</div>
<?php
get_footer();