<?php

class Theme_Widget_Banners extends WP_Widget
{
  public function __construct()
  {
    parent::__construct(
    // Base ID of your widget
      'theme_banners',
      // Widget name will appear in UI
      __('Баннеры'),
      // Widget options
      [
        'classname' => 'widget-banners'
      ]
    );
  }

  public static function init ()
  {
    $self = new self;
    add_action('widgets_init', [$self, 'widget_load']);
  }

  public function widget_load()
  {
    register_widget('Theme_Widget_Banners');
  }

  /**
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    $slider_id = $instance['slider'];
    $layout = $instance['layout'];
    $numberposts = (!empty($instance['numberposts'])) ? $instance['numberposts'] : $args['numberposts'];

    if (absint($slider_id) > 0) {
      $banners = Theme_Posts_Banners::get_slider_banners($slider_id, $numberposts);

      $template = locate_template('templates/widgets/banners-' . $layout . '.php', false);

      include $template;
    }
  }

  /**
   * Выводит форму настройки виджета
   * @param array $instance
   * @return string|void
   */
  public function form($instance)
  {
    $slider_choices = [
      0 => __('Не выбрано'),
    ];
    $slider_choices_items = get_terms('slider', ['hide_empty' => false]);

    foreach ($slider_choices_items as $item) {
      $slider_choices[$item->term_id] = $item->name;
    }

    $args['slider_choices'] = $slider_choices;

    $args['title'] = [
      'id'    => $this->get_field_id('title'),
      'name'  => $this->get_field_name('title'),
      'value' => (isset($instance['title'])) ? esc_attr($instance['title']) : false,
    ];

    $args['description'] = [
      'id'    => $this->get_field_id('description'),
      'name'  => $this->get_field_name('description'),
      'value' => (isset($instance['description'])) ? esc_attr($instance['description']) : false,
    ];

    $args['slider'] = [
      'id'    => $this->get_field_id('slider'),
      'name'  => $this->get_field_name('slider'),
      'value' => (isset($instance['slider'])) ? esc_attr($instance['slider']) : false,
    ];

    $args['numberposts'] = [
      'id'    => $this->get_field_id('numberposts'),
      'name'  => $this->get_field_name('numberposts'),
      'value' => (isset($instance['numberposts'])) ? intval($instance['numberposts']) : 5,
    ];

    $args['layout'] = [
      'id'    => $this->get_field_id('layout'),
      'name'  => $this->get_field_name('layout'),
      'value' => (isset($instance['layout'])) ? esc_attr($instance['layout']) : 'cover',
    ];

    get_template_part('templates/admin/form-widget', 'banners', $args);
  }

  /**
   * Обновляет настройки виджета
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
    $instance['slider'] = (!empty($new_instance['slider'])) ? absint($new_instance['slider']) : '';
    $instance['numberposts'] = (!empty($new_instance['numberposts'])) ? absint($new_instance['numberposts']) : 5;
    $instance['layout'] = (!empty($new_instance['layout'])) ? strip_tags($new_instance['layout']) : '';

    return $instance;
  }


}