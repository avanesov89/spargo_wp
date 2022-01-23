<?php
/**
 * Шаблон отдельной страницы Услуги
 */
get_header();

do_action('breadcrumbs', ['title' => Theme_Posts_Service::get_option('main_title')]);

$action = [
  'form_id'     => get_field('action_form'),
  'description' => get_field('action_description'),
  'btn'         => get_field('action_btn'),
];
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content wrapper__content-75 text__block">
          <?php get_template_part('templates/content/single', 'service'); ?>
        </div>

        <div class="wrapper__sidebar">
          <div class="wrapper__sidebar-sticky">
            <?php get_template_part('templates/widgets/service', 'action', $action); ?>

            <?php get_template_part('templates/widgets/service', 'list', ['active_id' => get_the_ID()]); ?>
          </div>
        </div>

        <?php get_template_part('templates/widgets/service', 'scrollable'); ?>

      </div>
    </div>
  </div>
<?php
if ($action['form_id']) {
  get_template_part('templates/forms/service', 'modal', ['form_id' => $action['form_id']]);
}
get_footer();