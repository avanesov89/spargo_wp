<?php

class Theme_Ajax
{
  private static $instance;

  public static function create()
  {
    return (null === self::$instance) ? self::$instance = new self() : self::$instance;
  }

  public static function init()
  {
    $self = new self();
    // Отображает форму запроса цены
    add_action('wp_ajax_form_vacancy_load', [$self, 'form_vacancy_load']);
    add_action('wp_ajax_nopriv_form_vacancy_load', [$self, 'form_vacancy_load']);
  }

  public function form_vacancy_load()
  {
    $vacancy_id = absint($_POST['vacancy']);
    $form_id = Theme_Posts_Vacancy::get_option('form_id');

    if (absint($form_id) > 0) {
      ob_start();
      get_template_part('templates/forms/vacancy', 'modal', ['vacancy_id' => $vacancy_id, 'form_id' => $form_id]);
      $html = ob_get_contents();
      ob_end_clean();

      wp_send_json_success($html);
    } else {
      wp_send_json_error('Форма запроса цены не настроена');
    }

  }
}