<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */

get_header();

$post_type_obj = get_post_type_object( 'dev_post' );

do_action('breadcrumbs', ['title' => $post_type_obj->description]);

while (have_posts()) :
  the_post();

  get_template_part('templates/content/single-post', 'dev');

endwhile; // End of the loop.

get_footer();
