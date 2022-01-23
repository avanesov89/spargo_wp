<?php
/**
 * Шаблон содержимого страницы услуги
 */
the_title('<h1>', '</h1>');

the_content(
  sprintf(
    wp_kses(
    /* translators: %s: Name of current post. Only visible to screen readers */
      __('Читать далее<span class="screen-reader-text"> "%s"</span>'),
      [
        'span' => [
          'class' => [],
        ],
      ]
    ),
    get_the_title()
  )
);

wp_link_pages(
  [
    'before' => '<div class="page-links">' . __('Страницы:'),
    'after'  => '</div>',
  ]
);
?>

