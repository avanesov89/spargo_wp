<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Spago
 * @since 0.1.0
 */

get_header();

do_action('breadcrumbs', ['title' => __('Ошибка 404')]);
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block">
        <div class="error_page">
          <?php theme_svg('error_page'); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="footnote">
      <div class="footnote__content">
        <div class="footnote__title">
          <?php _e('Страница не найдена!'); ?>
        </div>
        <?php printf('Воспользуйтесь поиском или <a href="%1$s" title="Главная страница">перейдите</a> на главную страницу сайта.', home_url()); ?>
      </div>
    </div>
  </div>
</div>
<?php
get_footer();