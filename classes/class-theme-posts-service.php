<?php
class Theme_Posts_Service
{
  private static $instance;

  public $labels;

  public $args;

  public $type = 'service';

  public $settings;

  /**
   * Создает экземпляр класса
   * @return Theme_Posts_Service
   */
  public static function create()
  {
    return (null === self::$instance) ? self::$instance = new self() : self::$instance;
  }

  public static function init()
  {
    $self = new self();

    // Ярлыки для постов
    $self->labels['post'] = [
      'name'                  => __('Услуги'),  // основное название для типа записи
      'singular_name'         => __('Услуга'),  // название для одной записи этого типа
      'add_new'               => __('Добавить услугу'), // для добавления новой записи
      'add_new_item'          => __('Новая услуга'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать услугу'), // для редактирования типа записи
      'new_item'              => __('Новая услуга'),  // текст новой записи
      'view_item'             => __('Просмотр услуги'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск услуги'), // для поиска по этим типам записи
      'not_found'             => __('Нет услуг'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Услуги'),  // название меню
      'archives'              => __('Полный цикл услуг'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Услуга'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Изображение услуги'),  // изображение записи
      'set_featured_image'    => __('Загрузить изображение услуги'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить изображение услуги'),  // Удалить изображение записи
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Услуги'),
      'labels'                => $self->labels['post'],
      'description'           => __('Полный цикл услуг'),
      'public'                => true,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => 'services',
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-admin-generic',
      'capability_type'       => 'post',
      'supports'              => ['title', 'excerpt', 'editor', 'thumbnail'],
      'query_var'             => true,
      'capabilities'         => [
        'edit_post'          => 'edit_' . $self->type,
        'edit_others_posts' => 'edit_others_' . $self->type .'s',
        'read_post'          => 'read_' . $self->type,
        'delete_post'        => 'delete_' . $self->type,
        'publish_posts'      => 'publish_' . $self->type,
        'edit_posts'         => 'edit_' . $self->type .'s',
        'delete_posts'       => 'delete_' . $self->type .'s',
      ],
      'map_meta_cap'          => true
    ];

    // Регистрирует новый тип постов
    add_action('init', [$self, 'register_post_type']);
    // Устанавливает права доступа для управлениями записями
    add_action('admin_init', [$self, 'set_post_caps']);
    // Регистрирует новые дополнительные поля
    add_action('add_meta_boxes', [$self, 'register_post_acf']);
    // Настройка колонок для списка записей в админке
    add_filter('manage_' . $self->type . '_posts_columns', [$self, 'custom_post_columns']);
    // Содержимое кастомных колонок для списка записей в админке
    add_action('manage_' . $self->type . '_posts_custom_column', [$self, 'custom_post_columns_content'], 10, 2);
    // Регистрирует опции настроек плагина для типов записи "partner"
    add_action('admin_init', [$self, 'register_settings']);
    // Добавляет пункт меню для настройки
    add_action('admin_menu', [$self, 'admin_menu_setup']);
  }

  /**
   * Регистрирует новый тип постов
   */
  public function register_post_type()
  {
    register_post_type($this->type, $this->args['post']);
  }

  /**
   * Устанавливает права доступа для управлениями записями
   */
  public function set_post_caps()
  {
    // Права для администратора
    $admins = get_role('administrator');

    $admins->add_cap('publish_' . $this->type);
    $admins->add_cap('edit_' . $this->type . 's');
    $admins->add_cap('edit_' . $this->type);
    $admins->add_cap('edit_others_' . $this->type . 's');
    $admins->add_cap('delete_' . $this->type . 's');
    $admins->add_cap('delete_' . $this->type);

    // Права для отдела кадров
    $editor = get_role('editor');
    if (!empty($editor)) {
      $editor->add_cap('read_' . $this->type);
      $editor->add_cap('publish_' . $this->type);
      $editor->add_cap('edit_' . $this->type . 's');
      $editor->add_cap('edit_' . $this->type);
      $editor->add_cap('edit_others_' . $this->type . 's');
      $editor->add_cap('delete_' . $this->type . 's');
      $editor->add_cap('delete_' . $this->type);
    }
  }

  /**
   * Регистрирует новые дополнительные поля
   */
  public function register_post_acf()
  {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group([
        'key' => 'group_61c72f4ea1ea3',
        'title' => 'Услуги',
        'fields' => [
          [
            'key' => 'field_61c72fa2f3724',
            'label' => 'Название кнопки призыва к действию',
            'name' => 'action_btn',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ],
          [
            'key' => 'field_61c72f78f4de0',
            'label' => 'Превью-текст для блока «Заказать услугу»',
            'name' => 'action_description',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
          ],
          [
            'key' => 'field_61c72fbe62c12',
            'label' => 'Форма обратной связи',
            'name' => 'action_form',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'post_type' => [
              0 => 'wpcf7_contact_form',
            ],
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
            'ui' => 1,
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'service',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
      ]);

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

        if ($key == 'cb' && !isset($columns[$this->type . '-thumb'])) {
          $new_columns[$this->type . '-thumb'] = __('Изображение', THEME_NAME);
        }

        if ($key == 'title' && !isset($columns[$this->type . '-preview'])) {
          $new_columns[$this->type . '-preview'] = __('Краткое описание');
        }
      }
    }

    return (!empty($new_columns)) ? $new_columns : $columns;
  }

  /**
   * Содержимое кастомных колонок
   *
   * @param [type] $column
   * @param [type] $post_id
   * @return void
   */
  public function custom_post_columns_content($column, $post_id)
  {
    switch ($column) {
      case $this->type . '-thumb':
        $no_image = '<span class="dashicons dashicons-format-image"></span>';
        if (has_post_thumbnail($post_id)) {
          theme_svg(get_the_post_thumbnail_url(), true);
        } else {
          echo $no_image;
        }
        break;

      case $this->type . '-preview':
        echo get_the_excerpt($post_id);
        break;
    }
  }

  /**
   * Регистрирует опции настроек плагина для типов записи "doctor"
   */
  public function register_settings()
  {
    $keys = [
      'main_title',       // Заголовок раздела
      'main_description',      // Описание в подвале раздела
    ];

    foreach ($keys as $key) {
      $this->settings[$key] = get_option('theme_' . $this->type . '_' . $key);
      register_setting('theme_' . $this->type, 'theme_' . $this->type . '_' . $key);
    }
  }

  /**
   * Добавляет пункт меню для настройки
   */
  public function admin_menu_setup()
  {
    add_submenu_page(
      'edit.php?post_type=' . $this->type,  // Parent slug
      __('Настройки'),                                 // Page title
      __('Настройки'),                                 // Menu title
      'administrator',                       // Capability
      'theme-' . $this->type . '-options',  // Menu slug
      [$this, 'admin_menu_options']                   // Function
    );
  }

  /**
   * Выводит шаблон для настроек типа записи
   */
  public function admin_menu_options()
  {
    get_template_part('templates/admin/settings', $this->type, $this->settings);
  }

  /**
   * Возвращает настройки типа постов
   * @param string $key
   * @return false|string
   */
  public static function get_option($key = '')
  {
    $self = new self();

    if (!empty($key)) {
      return (!empty($self->settings[$key])) ? $self->settings[$key] : get_option('theme_' . $self->type . '_' . $key);
    } else {
      return false;
    }
  }
}
