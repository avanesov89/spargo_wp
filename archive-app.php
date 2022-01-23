<?php
/**
 * The template for displaying archive app posts
 *
 * @link https://github.com/avanesov89/spargodev/blob/master/src/partials/documents.html
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
get_template_part('templates/base/header-archive', 'app');
$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block app__content">
        <?php if ($main_description = Theme_Posts_App::get_option('main_description')) : ?>
          <div class="text__page">
            <?php echo apply_filters('the_content', $main_description); ?>
          </div>
        <?php endif; ?>

        <?php if ($pre_title = Theme_Posts_App::get_option('pre_title')) : ?>
          <h2 class="app__content-title">
            <?php echo $pre_title; ?>
          </h2>
        <?php endif; ?>

        <nav class="app__all">
          <div class="app__all-list">
            <div class="app__all-item">
              <a href="<?php echo get_post_type_archive_link('app'); ?>" title="<?php _e('Все программы'); ?>"
                 class="app__all-link <?php if (!$term) : ?>app__all-link--active<?php endif; ?>">
                <?php _e('Все программы'); ?>
              </a>
            </div>
            <?php foreach ($industries = get_terms('industry', ['hide_empty'  => false]) as $industry) : ?>
              <div class="app__all-item">
                <a href="<?php echo get_term_link($industry->term_id); ?>" title="<?php echo $industry->name; ?>"
                   class="app__all-link <?php if ($term && $industry->term_id == $term->term_id) : ?>app__all-link--active<?php endif; ?>">
                  <?php echo $industry->name; ?>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </nav>

        <div class="app__list">
          <?php
          // Start the Loop.
          while (have_posts()) :
            the_post();

            get_template_part('templates/content/entry-post', 'app');
          endwhile;
          ?>
        </div>

      </div>
    </div>
  </div>

  <?php get_template_part('templates/widgets/app', 'industry'); ?>

  <?php get_template_part('templates/widgets/app', 'faq'); ?>

  <?php get_template_part('templates/widgets/app', 'clients'); ?>
</div>
<?php
get_footer();