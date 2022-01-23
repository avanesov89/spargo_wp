<?php
/**
 * The template for displaying archive posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_header();

do_action('breadcrumbs', ['title' => get_the_archive_title()]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block">

          <div class="last__renewal-list last__renewal-list--page">
            <?php
            // Start the Loop.
            while (have_posts()) :
              the_post();

              get_template_part('templates/content/entry-post', 'actual');
            endwhile;
            ?>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <?php
        $pagintion = paginate_links([
          'type'      => 'array',
          'prev_text' => __('Ранее'),
          'next_text' => __('Далее'),
        ]);
        get_template_part('templates/partials/pagination', null, $pagintion);
        ?>
      </div>
    </div>
  </div>
<?php
get_footer();
