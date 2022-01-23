<?php
/**
 * Шаблон отображения страницы решения
 */
get_header();

do_action('breadcrumbs', ['title' => get_the_title()]);

while (have_posts()) :
  the_post();

  get_template_part('templates/content/single-post', 'app');

endwhile; // End of the loop.

get_footer();