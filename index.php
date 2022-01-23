<?php

/**
 * The homepage template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */

get_header();

if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();

    get_template_part( 'templates/content', get_post_type() );
  }
}

get_footer();