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
        <div class="wrapper__content">
          <?php the_title('<h1>', '</h1>'); ?>
          <?php
          the_content(
            sprintf(
              wp_kses(
              /* translators: %s: Name of current post. Only visible to screen readers */
                __('Читать далее<span class="screen-reader-text"> "%s"</span>', THEME_NAME),
                [
                  'span' => [
                    'class' => [],
                  ],
                ]
              ),
              get_the_title()
            )
          );
          ?>
        </div>
      </div>

      <?php get_template_part('templates/partials/about', 'nav'); ?>

    </div>
  </div>
<?php
get_footer();