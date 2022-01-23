<?php

/**
 * The template for displaying archive vacancy posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
$vacancy_count = wp_count_posts('vacancy');

$departments = get_terms('department');

get_header();

do_action('breadcrumbs', ['title' => Theme_Posts_Vacancy::get_option('title_main')]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block">
          <?php echo Theme_Posts_Vacancy::get_option('description_main'); ?>

          <div class="vacancies__block">
            <div class="vacancies__block-title">
              <?php _e('Всего открытых вакансий'); ?>: <?php echo $vacancy_count->publish; ?>
            </div>

            <div class="vacancies__block-list">
              <?php foreach ($departments as $department) : ?>
                <div class="vacancies__block-item">
                  <details>
                    <summary>
                      <div class="vacancies__block-department">
                        <span><?php echo $department->name; ?></span>
                      </div>
                      <div class="vacancies__block-counter">
                        <?php echo $department->count; ?>
                      </div>
                    </summary>
                    <div class="vacancies__open">
                      <?php
                      if ($vacancies = Theme_Posts_Vacancy::get_department_vacancies($department->term_id)) :
                        while ($vacancies->have_posts()) :
                          $vacancies->the_post();
                          get_template_part('templates/content/entry-vacancy', 'open');
                        endwhile;
                        wp_reset_query();
                      endif;
                      ?>
                    </div>
                  </details>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="footnote">
        <div class="footnote__content">
          <div class="footnote__title"><?php _e('Не нашли подходящую вакансию?'); ?></div>

          <?php echo apply_filters('the_content', Theme_Posts_Vacancy::get_option('footer_main')); ?>
        </div>

        <div class="footnote__buttons">
          <button class="main__button btn-reset" data-hystmodal=".modal-vacancy">
            <?php _e('Отправить резюме'); ?>
          </button>
        </div>
      </div>
    </div>
  </div>
<?php
get_template_part('templates/forms/vacancy', 'modal', ['form_id' => Theme_Posts_Vacancy::get_option('form_id')]);

get_footer();
