<?php

class Theme_Widget_Posts extends WP_Widget
{
  public function __construct()
  {
    parent::__construct(
    // Base ID of your widget
      'theme_posts',
      // Widget name will appear in UI
      __('Новости'),
      // Widget options
      [
        'classname' => 'widget-posts'
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
    register_widget('Theme_Widget_Posts');
  }

  /**
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    $term_id = $instance['term'];
    $layout = (!empty($instance['layout'])) ? $instance['layout'] : $args['layout'];
    $numberposts = (!empty($instance['numberposts'])) ? $instance['numberposts'] : $args['numberposts'];

    $query_args = [
      'post_type'         => 'post',
      'nopaging'          => true,
      'posts_per_page'    => $numberposts,
    ];

    if ($term_id > 0) {
      $query_args['tax_query'] = [
        'relation'        => 'AND',
        [
          'taxonomy'      => 'category',
          'field'         => 'term_id',
          'terms'         => $term_id,
        ],
      ];
    }


    $posts = new WP_Query($query_args);

    $template = locate_template('templates/widgets/news-' . $layout . '.php', false);

    include $template;
  }

  /**
   * Выводит форму настройки виджета
   * @param array $instance
   * @return string|void
   */
  public function form($instance)
  {
    $terms_choices = [
      0 => __('Все рубрики'),
    ];

    $terms = get_categories([
      'taxonomy'     => 'category',
      'type'         => 'post',
      'child_of'     => 0,
      'parent'       => '',
      'orderby'      => 'name',
      'order'        => 'ASC',
      'hide_empty'   => 0,
      'hierarchical' => 1,
      'pad_counts'   => false,
      // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
    ]);

    foreach ($terms as $term) {
      $terms_choices[$term->term_id] = $term->name;
    }

    $args['terms_choices'] = $terms_choices;

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

    $args['term'] = [
      'id'    => $this->get_field_id('term'),
      'name'  => $this->get_field_name('term'),
      'value' => (isset($instance['term'])) ? esc_attr($instance['term']) : false,
    ];

    $args['more_label'] = [
      'id'    => $this->get_field_id('more_label'),
      'name'  => $this->get_field_name('more_label'),
      'value' => (isset($instance['more_label'])) ? esc_attr($instance['more_label']) : false,
    ];

    $args['numberposts'] = [
      'id'    => $this->get_field_id('numberposts'),
      'name'  => $this->get_field_name('numberposts'),
      'value' => (isset($instance['numberposts'])) ? intval($instance['numberposts']) : 5,
    ];

    $args['layout'] = [
      'id'    => $this->get_field_id('layout'),
      'name'  => $this->get_field_name('layout'),
      'value' => (isset($instance['layout'])) ? esc_attr($instance['layout']) : 'table',
    ];

    get_template_part('templates/admin/form-widget', 'posts', $args);
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
    $instance['term'] = (!empty($new_instance['term'])) ? absint($new_instance['term']) : '';
    $instance['more_label'] = (!empty($new_instance['more_label'])) ? strip_tags($new_instance['more_label']) : '';
    $instance['numberposts'] = (!empty($new_instance['numberposts'])) ? absint($new_instance['numberposts']) : 5;
    $instance['layout'] = (!empty($new_instance['layout'])) ? strip_tags($new_instance['layout']) : '';

    return $instance;
  }


}