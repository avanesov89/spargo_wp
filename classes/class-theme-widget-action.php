<?php

class Theme_Widget_Action extends WP_Widget
{
  public function __construct()
  {
    parent::__construct(
    // Base ID of your widget
      'theme_action',
      // Widget name will appear in UI
      __('Форма обратной связи'),
      // Widget options
      [
        'classname' => 'widget-action'
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
    register_widget('Theme_Widget_Action');
  }

  /**
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    $form_id = $instance['form'];

    if ($form_id > 0) {
      $template = locate_template('templates/widgets/action-main.php', false);

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
    $forms_choices = [
      0 => __('Не выбрано'),
    ];

    $forms = get_posts(['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1]);

    foreach ($forms as $form) {
      $forms_choices[$form->ID] = $form->post_title;
    }

    $args['forms_choices'] = $forms_choices;

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

    $args['form'] = [
      'id'    => $this->get_field_id('form'),
      'name'  => $this->get_field_name('form'),
      'value' => (isset($instance['form'])) ? esc_attr($instance['form']) : false,
    ];

    $args['btn_label'] = [
      'id'    => $this->get_field_id('btn_label'),
      'name'  => $this->get_field_name('btn_label'),
      'value' => (isset($instance['btn_label'])) ? esc_attr($instance['btn_label']) : false,
    ];

    get_template_part('templates/admin/form-widget', 'action', $args);
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
    $instance['form'] = (!empty($new_instance['form'])) ? absint($new_instance['form']) : 0;
    $instance['btn_label'] = (!empty($new_instance['btn_label'])) ? strip_tags($new_instance['btn_label']) : '';

    return $instance;
  }


}