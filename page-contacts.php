<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

do_action('breadcrumbs', ['title' => get_the_title()]);
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block contacts__flex">
          <div class="contacts__list">
            <?php echo apply_filters('the_content', get_the_content()); ?>

            <div class="contacts__all">
              <div class="contacts__department contacts__department-main">

                <?php get_template_part('templates/partials/contacts-department', 'division', ['field' => 'dep_main_title']); ?>

                <div class="contacts__department-content">
                  <?php get_template_part('templates/partials/contacts-department', 'address', ['field' => 'dep_main_address']); ?>

                  <?php get_template_part('templates/partials/contacts-department-phone', 'item', ['field' => 'dep_main_phone']); ?>

                  <?php get_template_part('templates/partials/contacts-department', 'email', ['field' => 'dep_main_email']); ?>

                  <?php get_template_part('templates/partials/contacts-department', 'email', ['field' => 'dep_main_smi']); ?>

                </div>
              </div>

              <div class="contacts__department contacts__department-support">
                <?php get_template_part('templates/partials/contacts-department', 'division', ['field' => 'dep_support_title']); ?>

                <div class="contacts__department-content">
                  <?php get_template_part('templates/partials/contacts-department-phone', 'row', ['field' => 'dep_support_phone_mobile', 'title' => __('Телефон')]); ?>

                  <?php get_template_part('templates/partials/contacts-department-phone', 'row', ['field' => 'dep_support_phone_city', 'title' => __('Телефон')]); ?>

                  <?php get_template_part('templates/partials/contacts-department', 'email', ['field' => 'dep_support_email']); ?>
                </div>
              </div>

              <div class="contacts__department contacts__department-manufacturer">
                <?php get_template_part('templates/partials/contacts-department', 'division', ['field' => 'dep_partner_title']); ?>

                <div class="contacts__department-content">
                  <?php get_template_part('templates/partials/contacts-department-phone', 'row', ['field' => 'dep_partners_phone']); ?>

                  <?php get_template_part('templates/partials/contacts-department', 'email', ['field' => 'dep_partner_email']); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="contacts__map">
            <?php if ($map_code = get_field('map_code')): ?>
              <div class="contacts__map-yandex">
                <?php echo $map_code; ?>
              </div>
            <?php endif; ?>

            <div class="contacts__scheme">
              <?php get_template_part('templates/partials/contacts-scheme', 'item', ['field' => 'metro_1']); ?>

              <?php get_template_part('templates/partials/contacts-scheme', 'item', ['field' => 'metro_2']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if ($form_id = get_field('form_id')) : ?>
  <div class="contacts__form">
    <div class="container">
      <div class="contacts__form-title">
        <?php echo get_field('form_title'); ?>
      </div>

      <?php echo do_shortcode('[contact-form-7 id="' . $form_id . '" html_class="main__form"]'); ?>
    </div>
  </div>
  <?php endif;
get_footer();
