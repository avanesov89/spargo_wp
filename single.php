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

$categories = get_the_category();
$top_category = $categories[0];

do_action('breadcrumbs', ['title' => $top_category->name]);

if (in_category('actual')) {
  get_template_part('templates/content/single-post', 'actual');
} else {
  get_template_part('templates/content/single', 'post', ['top_category' => $top_category]);
}

get_footer();