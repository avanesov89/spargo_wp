<?php
class Theme_Shortcodes
{
  public function __construct()
  {

  }

  public static function init ()
  {
    $self = new self;
    add_shortcode('show_quote', [$self, 'show_quote']);
  }

  /**
   * Переопределяет отображение галереи изображений
   *
   * @param array $atts
   * @return void
   */
  public function show_quote($atts)
  {
    if ( is_admin() ) return false;

    global $post;

    ob_start();
    get_template_part('templates/partials/about', 'quote', ['post_id' => $post->ID]);
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
  }

  public function doctor_manager_shortcode($atts)
  {
    if (empty($atts['id'])) {
      $html = '';
    } else {
      $doctor = Theme_Posts_Doctor::get_doctor_by_id(absint($atts['id']));
      $doctor->the_post();

      ob_start();
      get_template_part('templates/headers/header', 'doctor');
      wp_reset_query();
      $html = ob_get_contents();
      ob_end_clean();
    }

    return $html;
  }

  public function doctor_department_shortcode($atts)
  {
    if (empty($atts['id'])) {
      $html = '';
    } else {
      $limit = ($atts['limit']) ? $atts['limit'] : -1;

      $doctors = Theme_Posts_Doctor::get_doctors('staff', $atts['id'], $limit);

      $args['col_size'] = (isset($atts['columns']) && 12 % intval($atts['columns']) == 0) ? absint($atts['columns']) : 2;

      $html = '<div class="uk-grid uk-grid-medium">';

      ob_start();

      while ($doctors->have_posts()) :
        $doctors->the_post();
        get_template_part('templates/content/entry-doctor', 'staff', $args);
      endwhile;
      wp_reset_query();

      $html .= ob_get_contents();
      ob_end_clean();

      $html .= '</div>';
    }

    return $html;
  }
}