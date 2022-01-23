<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Spargo
 * @since 0.1.0
 */
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