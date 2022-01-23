<?php

class Theme_Posts_Banners
{
  private $labels;

  private $args;

  public function __construct()
  {
  }

  public static function init()
  {
    $self = new self;

    // Ярлыки для постов
    $self->labels['post'] = [
      'name'                  => __('Баннеры'),                         // основное название для типа записи
      'singular_name'         => __('Баннер'),                          // название для одной записи этого типа
      'add_new'               => __('Добавить баннер'),                 // для добавления новой записи
      'add_new_item'          => __('Новый баннер'),                    // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать баннер'),            // для редактирования типа записи
      'new_item'              => __('Новый баннер'),                    // текст новой записи
      'view_item'             => __('Просмотр баннера'),                // для просмотра записи этого типа.
      'search_items'          => __('Поиск баннера'),                   // для поиска по этим типам записи
      'not_found'             => __('Нет баннеров'),                    // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'),            // если не было найдено в корзине
      'parent_item_colon'     => __('Слайдер'),                         // для родителей (у древовидных типов)
      'menu_name'             => __('Баннеры'),                         // название меню
      'archives'              => __('Баннеры'),                         // заголовок в архиве записей
      'name_admin_bar'        => __('Баннер'),                          // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Изображение баннера'),             // изображение записи
      'set_featured_image'    => __('Установить изображение баннера'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить изображение баннера'),     // Удалить изображение записи
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Баннеры'),
      'labels'                => $self->labels['post'],
      'description'           => __('Ротатор баннеров'),
      'public'                => false,
      'publicly_queryable'    => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'show_in_rest'          => true,
      'hierarchical'          => false,
      'has_archive'           => false,
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-welcome-widgets-menus',
      'capability_type'       => 'post',
      'supports'              => ['title', 'editor', 'thumbnail'],
      'register_meta_box_cb'  => [$self, 'register_post_metaboxes'],
      'capabilities'         => [
        'publish_posts'      => 'publish_banner',
        'edit_posts'         => 'edit_banners',
        'edit_post'          => 'edit_banner',
        'delete_posts'       => 'delete_banners',
        'delete_post'        => 'delete_banner',
      ],
      'map_meta_cap'         => true
    ];

    // Ярлыки для таксономий
    $self->labels['tax'] = [
      'name'                  => __('Слайдеры'),
      'singular_name'         => __('Слайдер'),
      'all_items'             => __('Все слайдеры'),
      'edit_item'             => __('Редактировать слайдер'),
      'update_item'           => __('Обновить слайдер'),
      'add_new_item'          => __('Добавление слайдера'),
      'new_item_name'         => __('Слайдер'),
      'choose_from_most_used' => __('Выбрать из наиболее популярных слайдеров'),
    ];

    // Аргументы для регистрации таксономии для нового типа постов
    $self->args['tax'] = [
      'labels'              => $self->labels['tax'],
      'public'              => false,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_rest'        => true,
      'hierarchical'        => true,
      'show_admin_column'   => true,
      'capabilities'        => ['manage_terms', 'edit_terms', 'delete_terms', 'assign_terms'],
      'query_var'           => true,
      'sort'                => 'order',
    ];

    // Регистрирует новый тип постов
    add_action('init', [$self, 'register_post_type']);

    // Устанавливает права доступа для управлениями записями
    add_action('admin_init', [$self, 'set_post_caps']);

    // Регистрирует новый тип таксономии для баннеров - слайдеры
    add_action('init', [$self, 'register_post_taxonomy']);

    // Регистрирует новый мета-бокс для постов
    add_action('add_meta_boxes', [$self, 'register_post_metaboxes']);

    // Сохраняет мета-данные постов
    add_action('save_post', [$self, 'save_post_meta'], 1, 2);

    // Настройка колонок для списка баннеров в админке
    add_filter('manage_banner_posts_columns', [$self, 'custom_post_columns']);

    // Содержимое кастомных колонок
    add_action('manage_banner_posts_custom_column', [$self, 'custom_post_columns_content'], 10, 2);

    // Фильтр стандартных колонок таблицы
    add_filter('manage_banner_posts_columns', [$self, 'default_post_columns']);

    // Добавляет сортировку кастомных колонок
    add_filter('manage_edit-banner_sortable_columns', [$self, 'manage_post_sortable_columns']);

    // Добавляет фильтр по дополнительным колонкам
    add_action('restrict_manage_posts', [$self, 'filter_post_sortable_columns']);

    // Фильтрует платежи по дополнительным полям
    add_filter('request', [$self, 'posts_columns_filter_query']);
  }

  /**
   * Регистрирует новый тип постов
   *
   * @return void
   */
  public function register_post_type()
  {
    register_post_type('banner', $this->args['post']);
  }

  /**
   * Устанавливает права доступа для управлениями записями
   *
   * @return void
   */
  public function set_post_caps()
  {
    // gets the administrator role
    $admins = get_role('administrator');

    $admins->add_cap('publish_banner');
    $admins->add_cap('edit_banners');
    $admins->add_cap('edit_banner');
    $admins->add_cap('delete_banners');
    $admins->add_cap('delete_banner');
  }

  /**
   * Регистрирует новый тип таксономии для баннеров - слайдеры
   *
   * @return void
   */
  public function register_post_taxonomy()
  {
    register_taxonomy('slider', ['banner'], $this->args['tax']);
  }

  /**
   * Регистрирует новый мета-бокс для постов
   */
  public function register_post_metaboxes()
  {
    add_meta_box('theme_banner_metabox_main', __('Настройки баннера'), [$this, 'show_meta_box_main'], 'banner', 'side', 'default');
  }

  public function show_meta_box_main($post)
  {
    $meta = [
      'post_id'           => $post->ID,
      'url'               => get_post_meta($post->ID, 'url', 1),
      'blank'             => get_post_meta($post->ID, 'blank', 1),
      'video'             => get_post_meta($post->ID, 'video', 1),
    ];

    $template = locate_template('templates/admin/meta-banners.php', false, false);

    include($template);
  }

  /**
   * Сохраняет мета-данные постов
   *
   * @param [type] $post_id
   * @param [type] $post
   * @return mixed
   */
  public function save_post_meta($post_id, $post)
  {
    // Обрабатывает только посты типа banner
    if ($post->post_type != 'banner') {
      return $post_id;
    }
    // проверка
    if (isset($_POST['extra_fields_nonce'])) {
      if (!wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__)) return false;
    }
    // выходим если это автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
    // выходим если юзер не имеет право редактировать запись
    if (!current_user_can('edit_post', $post_id)) return false;
    // выходим если данных нет
    if (!isset($_POST['extra'])) return false;

    // Все ОК! Теперь, нужно сохранить/удалить данные
    // чистим все данные от пробелов по краям
    $_POST['extra'] = array_map('trim', $_POST['extra']);
    foreach ($_POST['extra'] as $key => $value) {
      // удаляем поле если значение пустое
      if (empty($value)) {
        delete_post_meta($post_id, $key);
        continue;
      }
      // add_post_meta() работает автоматически
      update_post_meta($post_id, $key, $value);
    }
    return $post_id;
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

        if ($key == 'cb' && !isset($columns['banner-thumb'])) {
          $new_columns['banner-thumb'] = __('Изображение', THEME_NAME);
        }

        if ($key == 'title' && !isset($columns['banner-description'])) {
          $new_columns['banner-description'] = __('Текст баннера', THEME_NAME);
        }
      }
    }

    return $new_columns;
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
      case 'banner-thumb':
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

      case 'banner-description':
        echo mb_substr(strip_tags( get_post_field('post_content', $post_id) ), 0, 140, 'utf-8') . '...';
        break;
    }
  }

  /**
   * Фильтр стандартных колонок таблицы
   *
   * @param [type] $columns
   * @return void
   */
  public function default_post_columns($columns)
  {
    unset($columns['date']);
    return $columns;
  }

  /**
   * Добавляет сортировку кастомных колонок
   *
   * @param [type] $columns
   * @return void
   */
  public function manage_post_sortable_columns($columns)
  {
    $columns['taxonomy-slider'] = 'taxonomy-slider';

    // Отключает сортировку по дате поста
    unset($columns['date']);

    return $columns;
  }

  /**
   * Добавляет фильтр по дополнительным колонкам
   *
   * @param [type] $post_type
   * @return void
   */
  public function filter_post_sortable_columns($post_type)
  {
    if ($post_type == 'banner') {
      $sliders = get_terms([
        'taxonomy' => 'slider',
        'hide_empty' => true,
      ]);

      $filter_slider = (isset($_GET['banner_slider'])) ? $_GET['banner_slider'] : 0;

      $template = locate_template('templates/admin/filter-banners.php', false, false);

      include($template);
    }
  }

  /**
   * Получает баннеры выбранного слайдера
   * @param int $slider_id
   * @param int $banners_count
   * @return false|WP_Query
   */
  public static function get_slider_banners($slider_id, $banners_count = 0)
  {
    $query = new WP_Query([
      'post_type'         => 'banner',
      'nopaging'          => true,
      'orderby'           => 'menu_item',
      'order'             =>  'ASC',
      'posts_per_page'    => ($banners_count > 0) ? $banners_count : -1,
      'tax_query'         => [
        'relation'        => 'AND',
        [
          'taxonomy'      => 'slider',
          'field'         => 'term_id',
          'terms'         => $slider_id,
        ],
      ],
      'meta_query'        => [
        'relation'        => 'AND',
        [
          'key'           => '_thumbnail_id',
          'value'         => '',
          'compare'       => '!=',
        ],
      ],
    ]);

    return ($query->have_posts()) ? $query : false;
  }

  public function posts_columns_filter_query($vars)
  {
    global $pagenow;
    global $post_type;

    if (!is_admin()) {
      return $vars;
    }

    // тут нужно указать все типы постов где нужен этот фильтр, например 'page','my_type_post' и т.д.
    $start_in_post_types = ['banner'];

    if (!empty($pagenow) && $pagenow == 'edit.php' && in_array($post_type, $start_in_post_types)) {
      if (!empty($_GET['filter_action'])) {
        $vars['tax_query'] = [
          'relation' => 'AND',
          [
            'taxonomy'  => 'slider',
            'field'     => 'id',
            'terms'     => absint($_GET['banner_slider']),
          ]
        ];
      }
    }

    return $vars;
  }
}
