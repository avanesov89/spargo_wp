<?php
/**
 * Шаблон для отображения архива услуг
 *
 * @link https://avanesov89.github.io/spargoprom/services-category.html
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.1.8
 */
get_header();

$archive_title = (!empty( Theme_Posts_Service::get_option('main_title') )) ? Theme_Posts_Service::get_option('main_title') : get_the_archive_title();
$archive_description = Theme_Posts_Service::get_option('main_description');

do_action('breadcrumbs', ['title' => $archive_title]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block">
          <?php if (!empty($archive_description)) : ?>
            <div class="text__page">
              <?php echo apply_filters('the_content', $archive_description); ?>
            </div>
          <?php endif; ?>

          <div class="services__list">
            <?php
            // Start the Loop.
            while (have_posts()) :
              the_post();

              get_template_part('templates/content/entry', 'service');
            endwhile;
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
get_footer();