<?php
/**
 * The template for displaying archive partners posts
 *
 * @link https://github.com/avanesov89/spargodev/blob/master/src/partials/documents.html
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_header();

$partners_title = (!empty( Theme_Posts_Partner::get_option('main_title') )) ? Theme_Posts_Partner::get_option('main_title') : get_the_archive_title();
do_action('breadcrumbs', ['title' => $partners_title]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block">
          <?php if (!empty($pre_title = Theme_Posts_Partner::get_option('pre_title'))) : ?>
            <h1><?php echo $pre_title; ?></h1>
          <?php endif; ?>

          <?php
          if (!empty($main_description = Theme_Posts_Partner::get_option('main_description'))) :
            echo apply_filters('the_content', $main_description);
          endif;
          ?>

          <div class="partners__list">
            <?php
            // Start the Loop.
            while (have_posts()) :
              the_post();

              get_template_part('templates/content/entry', 'partner');
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

    <div class="container">
      <?php get_template_part('templates/partials/footer', 'partner'); ?>
    </div>
  </div>
<?php
get_footer();
