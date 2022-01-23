<?php

/**
 * Header темы
 *
 * Этот шаблон отображает все, начиная от <head> до <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.1
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#34495E">
  <link rel="profile" href="https://gmpg.org/xfn/11" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div class="site-container">
    <!-- #page start -->
    <a class="skip-link screen-reader-text" href="#content"><?php _e('Перейти к содержимому', THEME_NAME); ?></a>

    <header class="header">
      <?php get_template_part('templates/base/header', 'top'); ?>

      <?php get_template_part('templates/base/header', 'main'); ?>
    </header>