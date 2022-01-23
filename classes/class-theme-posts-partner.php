<?php
class Theme_Posts_Partner
{
  private static $instance;

  public $labels;

  public $args;

  public $type = 'partner';

  public $settings;

  /**
   * Создает экземпляр класса
   * @return Theme_Posts_Partner
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
      'name'                  => __('Партнеры'),  // основное название для типа записи
      'singular_name'         => __('Партнер'),  // название для одной записи этого типа
      'add_new'               => __('Добавить партнера'), // для добавления новой записи
      'add_new_item'          => __('Новый партнер'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать партнера'), // для редактирования типа записи
      'new_item'              => __('Новый партнер'),  // текст новой записи
      'view_item'             => __('Просмотр партнера'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск партнера'), // для поиска по этим типам записи
      'not_found'             => __('Нет партнеров'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Партнеры'),  // название меню
      'archives'              => __('Партнеры и поставщики'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Партнер'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Логотип компании'),  // изображение записи
      'set_featured_image'    => __('Загрузить логотип компании'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить логотип компании'),  // Удалить изображение записи
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Партнеры'),
      'labels'                => $self->labels['post'],
      'description'           => __('Партнеры и поставщики'),
      'public'                => false,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => 'partners',
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-id-alt',
      'capability_type'       => 'post',
      'supports'              => ['title', 'thumbnail'],
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
        'key' => 'group_61bb9b2f15844',
        'title' => 'Данные партнера',
        'fields' => [
          [
            'key' => 'field_61bb9b482f92f',
            'label' => 'Адрес офиса компании',
            'name' => 'address',
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
            'key' => 'field_61bb9b5a2f930',
            'label' => 'Адрес сайта компании',
            'name' => 'website',
            'type' => 'url',
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
          ],
          [
            'key' => 'field_61bb9b742f931',
            'label' => 'Телефон компании',
            'name' => 'phone',
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
            'key' => 'field_61bb9b8e2f932',
            'label' => 'E-mail компании',
            'name' => 'email',
            'type' => 'email',
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
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'partner',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'field',
        'hide_on_screen' => [
          0 => 'discussion',
          1 => 'comments',
          2 => 'format',
          3 => 'categories',
          4 => 'tags',
        ],
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
          $new_columns[$this->type . '-thumb'] = __('Логотип', THEME_NAME);
        }

        if ($key == 'title' && !isset($columns[$this->type . '-data'])) {
          $new_columns[$this->type . '-data'] = __('Данные партнера');
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

      case $this->type . '-data':
        // Адрес офиса компании
        if ($address = get_field('address', $post_id))
          echo '<p class="column-partner-data__item"><span class="dashicons dashicons-location-alt"></span><span>' . $address . '</span></p>';
        // Адрес сайта компании
        if ($website = get_field('website', $post_id))
          echo '<p class="column-partner-data__item"><span class="dashicons dashicons-admin-site"></span><span>' . parse_url($website, PHP_URL_HOST) . '</span></p>';
        // Телефон компании
        if ($phone = get_field('phone', $post_id))
          echo '<p class="column-partner-data__item"><span class="dashicons dashicons-phone"></span><span>' . $phone . '</span></p>';
        // E-mail компании
        if ($email = get_field('email', $post_id))
          echo '<p class="column-partner-data__item"><span class="dashicons dashicons-email"></span><span>' . $email . '</span></p>';
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
      'pre_title', // Описание раздела
      'main_description',      // Описание в подвале раздела
      'per_page',          // ID CF7 формы обратной связи
      'footer_title',
      'footer_description',
      'footer_button',
      'form_id',
    ];

    foreach ($keys as $key) {
      $this->settings[$key] = get_option('theme_partners_' . $key);
      register_setting('theme_partners', 'theme_partners_' . $key);
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
      return (!empty($self->settings[$key])) ? $self->settings[$key] : get_option('theme_partners_' . $key);
    } else {
      return false;
    }
  }
}