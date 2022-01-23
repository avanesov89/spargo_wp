<?php
class Theme_Posts_App
{
  private static $instance;

  public $labels;

  public $args;

  public $type = 'app';

  public $tax_type = 'industry';

  public $settings;

  /**
   * @return Theme_Posts_App
   */
  public static function create()
  {
    return (null === self::$instance) ? self::$instance = new self() : self::$instance;
  }

  public static function init()
  {
    $self = new self();

    // Ярлыки для постов
    $self->labels['post'] = $self->set_labels_posts();
    // Ярлыки для таксономий
    $self->labels['tax'] = $self->set_labels_tax();
    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Продукты'),
      'labels'                => $self->labels['post'],
      'description'           => __('Комплексные IT-решения для автоматизации бизнес процессов'),
      'public'                => true,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => true,
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-products',
      'capability_type'       => 'post',
      'supports'              => ['title', 'editor', 'excerpt', 'thumbnail'],
      'query_var'             => true,
      'taxonomies'            => [$self->tax_type],
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

    // Аргументы для регистрации таксономии для нового типа постов
    $self->args['tax'] = [
      'labels'            => $self->labels['tax'],
      'public'            => true,
      'hierarchical'      => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'capabilities'      => [
        'manage_terms'  => 'manage_' . $self->tax_type. 's',
        'edit_terms'    => 'edit_' . $self->tax_type. 's',
        'delete_terms'  => 'delete_' . $self->tax_type. 's',
        'assign_terms'  => 'assign_' . $self->tax_type. 's',
      ]
    ];

    // Регистрирует новый тип постов
    add_action('init', [$self, 'register_post_type']);

    // Регистрирует новый тип таксономии для постов (рубрики)
    add_action('init', [$self, 'register_post_taxonomy']);

    // Устанавливает права доступа для управлениями записями
    add_action('admin_init', [$self, 'set_post_caps']);

    // Регистрирует новые дополнительные поля
    add_action('add_meta_boxes', [$self, 'register_post_acf']);

    // Регистрирует опции настроек плагина для типов записи "partner"
    add_action('admin_init', [$self, 'register_settings']);

    // Добавляет пункт меню для настройки
    add_action('admin_menu', [$self, 'admin_menu_setup']);

    // Настройка колонок для списка записей в админке
    add_filter('manage_' . $self->type . '_posts_columns', [$self, 'custom_post_columns']);

    // Содержимое кастомных колонок для списка записей в админке
    add_action('manage_' . $self->type . '_posts_custom_column', [$self, 'custom_post_columns_content'], 10, 2);
  }

  /**
   * Ярлыки для постов
   * @return array
   */
  public function set_labels_posts()
  {
    return [
      'name'                  => __('Продукты'),  // основное название для типа записи
      'singular_name'         => __('Продукт'),  // название для одной записи этого типа
      'add_new'               => __('Добавить продукт'), // для добавления новой записи
      'add_new_item'          => __('Новый продукт'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать продукт'), // для редактирования типа записи
      'new_item'              => __('Новый продукт'),  // текст новой записи
      'view_item'             => __('Просмотр продукта'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск продукта'), // для поиска по этим типам записи
      'not_found'             => __('Нет продуктов'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Решения'),  // название меню
      'archives'              => __('Наши продукты'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Продукт'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Изображение продукта'),  // изображение записи
      'set_featured_image'    => __('Загрузить изображение продукта'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить изображение продукта'),  // Удалить изображение записи
    ];
  }

  /**
   * Ярлыки для таксономий
   * @return array
   */
  public function set_labels_tax()
  {
    return [
      'name'                  => __('Отрасли'),
      'singular_name'         => __('Отрасль'),
      'all_items'             => __('Все отрасли'),
      'edit_item'             => __('Редактировать отрасли'),
      'update_item'           => __('Обновить отрасль'),
      'add_new_item'          => __('Создать отрасль'),
      'new_item_name'         => __('Отрасль'),
      'choose_from_most_used' => __('Выбрать из наиболее популярных отраслей'),
    ];
  }

  /**
   * Регистрирует новый тип постов
   */
  public function register_post_type()
  {
    register_post_type($this->type, $this->args['post']);
  }

  /**
   * Регистрирует новый тип таксономии для постов (рубрики)
   */
  public function register_post_taxonomy()
  {
    register_taxonomy($this->tax_type, [$this->type], $this->args['tax']);
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
    $admins->add_cap('manage_' . $this->tax_type. 's');
    $admins->add_cap('edit_' . $this->tax_type. 's');
    $admins->add_cap('delete_' . $this->tax_type. 's');
    $admins->add_cap('assign_' . $this->tax_type. 's');

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
      $editor->add_cap('manage_' . $this->tax_type. 's');
      $editor->add_cap('edit_' . $this->tax_type. 's');
      $editor->add_cap('delete_' . $this->tax_type. 's');
      $editor->add_cap('assign_' . $this->tax_type. 's');
    }
  }

  /**
   * Регистрирует новые дополнительные поля
   */
  public function register_post_acf()
  {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group([
        'key' => 'group_61dc8645b45c4',
        'title' => 'Решения',
        'fields' => [
          [
            'key' => 'field_61dc8655b85e8',
            'label' => 'Код презентации',
            'name' => 'presentation',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'tabs' => 'text',
            'media_upload' => 1,
            'toolbar' => 'full',
            'delay' => 0,
          ],
          [
            'key' => 'field_61ddca6b26a34',
            'label' => 'Дополнительные модули',
            'name' => 'modules',
            'type' => 'group',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'layout' => 'block',
            'sub_fields' => [
              [
                'key' => 'field_61ddca7c26a35',
                'label' => 'Заголовок блока',
                'name' => 'modules_title',
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
                'key' => 'field_61ddca9426a36',
                'label' => 'Описание блока',
                'name' => 'modules_description',
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
                'rows' => 3,
                'new_lines' => '',
              ],
              [
                'key' => 'field_61ddcacfb94f6',
                'label' => 'Список модулей',
                'name' => 'modules_list',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'tabs' => 'text',
                'media_upload' => 1,
                'toolbar' => 'full',
                'delay' => 0,
              ],
            ],
          ],
          [
            'key' => 'field_61ddd0d9b8588',
            'label' => 'Документация',
            'name' => 'docs',
            'type' => 'group',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'layout' => 'block',
            'sub_fields' => [
              [
                'key' => 'field_61ddd49d324d1',
                'label' => 'Файлы',
                'name' => 'files',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'post_type' => [
                  0 => 'attachment',
                ],
                'taxonomy' => '',
                'filters' => [
                  0 => 'search',
                ],
                'elements' => [
                  0 => 'featured_image',
                ],
                'min' => '',
                'max' => '',
                'return_format' => 'object',
              ],
              [
                'key' => 'field_61ddd4decf838',
                'label' => 'Системные требования',
                'name' => 'table',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 0,
              ],
            ],
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'app',
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
   * Регистрирует опции настроек плагина для типов записи "doctor"
   */
  public function register_settings()
  {
    $keys = [
      'main_title',       // Заголовок раздела
      'main_description', // Описание раздела
      'pre_title',        // Заголовок перед списком продуктов
      'per_page',         // Количество записей на странице
      'form_id',          // ID CF7 формы обратной связи
      'industry_slider',  // ID сдайдера с отраслевыми решениями
      'faq_slider',       // ID сдайдера с вопросами и ответами
      'clients_slider',   // ID сдайдера Крупные сети
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

  /**
   * Настройка колонок для списка баннеров в админке
   * @param array $columns
   * @return array
   */
  public function custom_post_columns($columns)
  {
    if (is_array($columns)) {
      foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key == 'cb' && !isset($columns[$this->type . '-thumb'])) {
          $new_columns[$this->type . '-thumb'] = __('Логотип', THEME_NAME);
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
          add_thickbox();
          echo '<a href="' . get_the_post_thumbnail_url($post_id, 'attachment') . '?width=600&height=550" class="thickbox">';
          echo get_the_post_thumbnail($post_id, 'thumb', ['class' => 'banner-thumbnail']);
          echo '</a>';
        } else {
          echo $no_image;
        }
        break;
    }
  }
}