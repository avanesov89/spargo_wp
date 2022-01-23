<?php

/**
 * The template for displaying all single page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

do_action('breadcrumbs', ['title' => get_the_title()]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block news__element">
          <?php
          while (have_posts()) :
            the_post();

            get_template_part('templates/content/entry', 'page');

          endwhile; // End of the loop.
          ?>
        </div>
      </div>
    </div>
  </div>
<?php
get_footer();