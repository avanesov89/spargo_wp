<?php

class Theme_Widget_Reviews extends WP_Widget
{
  public function __construct()
  {
    parent::__construct(
    // Base ID of your widget
      'theme_reviews',
      // Widget name will appear in UI
      __('Отзывы'),
      // Widget options
      [
        'classname' => 'widget-reviews'
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
    register_widget('Theme_Widget_Reviews');
  }

  /**
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    $numberposts = (!empty($instance['numberposts'])) ? $instance['numberposts'] : $args['numberposts'];

    $reviews = Theme_Posts_Reviews::get_reviews($numberposts);

    if ($reviews) {
      $template = locate_template('templates/widgets/reviews-main.php', false);

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

    $args['numberposts'] = [
      'id'    => $this->get_field_id('numberposts'),
      'name'  => $this->get_field_name('numberposts'),
      'value' => (isset($instance['numberposts'])) ? intval($instance['numberposts']) : 5,
    ];

    $args['btn_label'] = [
      'id'    => $this->get_field_id('btn_label'),
      'name'  => $this->get_field_name('btn_label'),
      'value' => (isset($instance['btn_label'])) ? esc_attr($instance['btn_label']) : false,
    ];

    get_template_part('templates/admin/form-widget', 'reviews', $args);
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
    $instance['numberposts'] = (!empty($new_instance['numberposts'])) ? absint($new_instance['numberposts']) : 2;
    $instance['btn_label'] = (!empty($new_instance['btn_label'])) ? strip_tags($new_instance['btn_label']) : '';

    return $instance;
  }


}