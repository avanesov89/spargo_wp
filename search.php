<?php
/**
 * Шаблон страницы с результатами поиска
 */
get_header();

do_action('breadcrumbs', ['title' => sprintf(esc_html__('Результат поиска "%s"', THEME_NAME), esc_html(get_search_query()))]);
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block">
        <div class="blog__items">
          <?php
          // Start the Loop.
          while (have_posts()) :
            the_post();

            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part('templates/content/entry-search', 'result');

            // End the loop.
          endwhile;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <?php
      $pagination = paginate_links([
        'type'      => 'array',
        'prev_text' => __('Ранее'),
        'next_text' => __('Далее'),
      ]);
      get_template_part('templates/partials/pagination', null, $pagination);
      ?>
    </div>
  </div>
</div>
<?php
get_footer();
