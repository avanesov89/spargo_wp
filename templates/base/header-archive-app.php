<?php
$main_title = (Theme_Posts_App::get_option('main_title')) ? Theme_Posts_App::get_option('main_title') : __('Комплексные IT-решения для автоматизации бизнес процессов');

get_header();

// Хлебные крошки
do_action('breadcrumbs', ['title' => $main_title]);