<?php

class Theme_Posts_Reviews
{
  private $labels;

  private $args;

  public $type = 'review';

  public $types = 'reviews';

  public function __construct()
  {
  }

  public static function init()
  {
    $self = new self;

    // Ярлыки для постов
    $self->labels['post'] = [
      'name'                  => __('Отзывы'),  // основное название для типа записи
      'singular_name'         => __('Отзыв'),  // название для одной записи этого типа
      'add_new'               => __('Добавить отзыв'), // для добавления новой записи
      'add_new_item'          => __('Новый отзыв'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать отзыв'), // для редактирования типа записи
      'new_item'              => __('Новый отзыв'),  // текст новой записи
      'view_item'             => __('Просмотр отзыва'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск отзыва'), // для поиска по этим типам записи
      'not_found'             => __('Нет отзывов'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Отзывы'),  // название меню
      'archives'              => __('Все отзывы'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Отзыв'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Скан отзыва'),  // изображение записи
      'set_featured_image'    => __('Загрузить скан отзыва'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить скан отзыва'),  // Удалить изображение записи
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Отзывы'),
      'labels'                => $self->labels['post'],
      'description'           => __('Отзывы клиентов'),
      'public'                => true,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => 'reviews',
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-format-chat',
      'capability_type'       => 'post',
      'supports'              => ['title', 'editor', 'thumbnail'],
      'query_var'             => true,
      'capabilities'         => [
        'publish_posts'      => 'publish_' . $self->type,
        'edit_posts'         => 'edit_' . $self->types,
        'edit_post'          => 'edit_' . $self->type,
        'delete_posts'       => 'delete_' . $self->type,
        'delete_post'        => 'delete_' . $self->type,
      ],
      'map_meta_cap'          => true
    ];

    // Регистрирует новый тип постов
    add_action('init', [$self, 'register_post_type']);

    // Устанавливает права доступа для управлениями записями
    add_action('admin_init', [$self, 'set_post_caps']);

    // Регистрирует новый мета-бокс для постов
    add_action('add_meta_boxes', [$self, 'register_post_acf']);

    // Настройка колонок для списка записей в админке
    add_filter('manage_' . $self->type . '_posts_columns', [$self, 'custom_post_columns']);

    // Содержимое кастомных колонок для списка записей в админке
    add_action('manage_' . $self->type . '_posts_custom_column', [$self, 'custom_post_columns_content'], 10, 2);
  }

  /**
   * Регистрирует новый тип постов
   *
   * @return void
   */
  public function register_post_type()
  {
    register_post_type($this->type, $this->args['post']);
  }

  /**
   * Устанавливает права доступа для управлениями записями
   *
   * @return void
   */
  public function set_post_caps()
  {
    // Права для администратора
    $admins = get_role('administrator');

    $admins->add_cap('publish_' . $this->type);
    $admins->add_cap('edit_' . $this->types);
    $admins->add_cap('edit_' . $this->type);
    $admins->add_cap('delete_' . $this->types);
    $admins->add_cap('delete_' . $this->type);

    // Права для редактора
    $editors = get_role('editor');

    $editors->add_cap('publish_' . $this->type);
    $editors->add_cap('edit_' . $this->types);
    $editors->add_cap('edit_' . $this->type);
    $editors->add_cap('delete_' . $this->types);
    $editors->add_cap('delete_' . $this->type);
  }

  /**
   * Регистрирует новый мета-бокс для постов
   */
  public function register_post_acf()
  {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
        'key' => 'group_61b26698befde',
        'title' => 'Автор отзыва',
        'fields' => array(
          [
            'key' => 'field_61b266c875e7f',
            'label' => 'Логотип компании',
            'name' => 'author_logo',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'return_format' => 'id',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
          ],
          array(
            'key' => 'field_61b267725b960',
            'label' => 'Должность',
            'name' => 'author_position',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => 3,
            'new_lines' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'review',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
      ));

    endif;
  }

  /**
   * Настройка колонок для списка баннеров в админке
   * @param $columns
   * @return mixed
   */
  public function custom_post_columns($columns)
  {
    if (is_array($columns)) {
      foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key == 'cb' && !isset($columns[$this->type . '-thumbnail'])) {
          $new_columns[$this->type . '-thumbnail'] = __('Логотип');
        }

        if ($key == 'title' && !isset($columns[$this->type . '-content'])) {
          $new_columns[$this->type . '-content'] = __('Отзыв');
        }
      }
    }

    return $new_columns;
  }

  /**
   * Содержимое кастомных колонок
   *
   * @param string $column
   * @param int $post_id
   * @return void
   */
  public function custom_post_columns_content($column, $post_id)
  {
    $post = get_post($post_id);
    switch ($column) {
      case $this->type . '-thumbnail':
        if ($logo = get_post_meta($post_id, 'author_logo', 1)) {
          echo wp_get_attachment_image(absint($logo), 'thumbnail', false, [
            'class' => 'admin-list__review-logo',
          ]); 
        } else {
          echo '<img src="' . THEME_ASSETS . 'svg/image-wireframe.svg" class="review-logo" width="60" height="60" />';
        }
        break;

      case $this->type . '-content':
        echo mb_substr($post->post_content, 0, 140, 'utf-8');
        if (mb_strlen($post->post_content, 'utf-8') > 140) {
          echo '...';
        }
        
        if ($author = get_post_meta($post_id, 'author_position', 1)) {
          echo '<p class="review-conent-position"><span class="dashicons dashicons-admin-users"></span> ' . $author . '</p>';
        }

        break;
    }
  }

  /**
   * Получает отзывы
   * @param int $numberposts
   * @return false|WP_Query
   */
  public static function get_reviews($numberposts = -1)
  {
    $query = new WP_Query([
      'post_type'         => 'review',
      'nopaging'          => true,
      'orderby'           => 'date',
      'order'             =>  'DESC',
      'posts_per_page'    => $numberposts
    ]);

    return ($query->have_posts()) ? $query : false;
  }
}
