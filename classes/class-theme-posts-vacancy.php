<?php

class Theme_Posts_Vacancy
{
  private static $instance;

  public $labels;

  public $args;

  public $type = 'vacancy';

  public $tax_type = 'department';

  public $settings;

  public static function create()
  {
    return (null === self::$instance) ? self::$instance = new self() : self::$instance;
  }

  public static function init()
  {
    $self = new self();
    // Ярлыки для постов
    $self->labels['post'] = [
      'name'                  => __('Вакансии'),  // основное название для типа записи
      'singular_name'         => __('Вакансия'),  // название для одной записи этого типа
      'add_new'               => __('Добавить вакансию'), // для добавления новой записи
      'add_new_item'          => __('Новая вакансия'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать вакансию'), // для редактирования типа записи
      'new_item'              => __('Новая вакансия'),  // текст новой записи
      'view_item'             => __('Просмотр вакансии'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск вакансии'), // для поиска по этим типам записи
      'not_found'             => __('Нет вакансий'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Вакансии'),  // название меню
      'archives'              => __('Открытые вакансии'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Вакансия'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Изображение вакансии'),  // изображение записи
      'set_featured_image'    => __('Загрузить изображение вакансии'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить изображение вакансии'),  // Удалить изображение записи
    ];

    // Ярлыки для таксономий
    $self->labels['tax'] = [
      'name'                  => __('Департаменты'),
      'singular_name'         => __('Департамент'),
      'all_items'             => __('Все департаменты'),
      'edit_item'             => __('Редактировать департамент'),
      'update_item'           => __('Обновить департамент'),
      'add_new_item'          => __('Создать департамент'),
      'new_item_name'         => __('Департамент'),
      'choose_from_most_used' => __('Выбрать из наиболее популярных департаментов'),
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Вакансии'),
      'labels'                => $self->labels['post'],
      'description'           => __('Вакансии компании'),
      'public'                => true,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => true,
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-businessman',
      'capability_type'       => $self->type,
      'supports'              => ['title', 'editor'],
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

    // Аргументы для регистрации таксономии для нового типа постов
    $self->args['tax'] = [
      'labels'            => $self->labels['tax'],
      'public'            => true,
      'hierarchical'      => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => ['slug' => 'department'],
      'sort'              => 'order',
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

    // Устанавливает заголовк для соержимого поста при его редактировании
    add_action('admin_footer', [$self, 'add_title_to_editor']);

    // Регистрирует новый мета-бокс для постов
    add_action('add_meta_boxes', [$self, 'register_post_acf']);

    // Настройка колонок для списка записей в админке
    add_filter('manage_' . $self->type . '_posts_columns', [$self, 'custom_post_columns']);

    // Содержимое кастомных колонок для списка записей в админке
    add_action('manage_' . $self->type . '_posts_custom_column', [$self, 'custom_post_columns_content'], 10, 2);

    // Добавляет фильтр по дополнительным колонкам
    add_action('restrict_manage_posts', [$self, 'filter_post_sortable_columns']);

    // Фильтрует записи по таксономиям
    add_filter('request', [$self, 'posts_columns_filter_query']);

    // Регистрирует опции настроек плагина для типов записи "doctor"
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
    $admins->add_cap('edit_' . $this->type .'s');
    $admins->add_cap('edit_' . $this->type);
    $admins->add_cap('edit_others_' . $this->type .'s');
    $admins->add_cap('delete_' . $this->type .'s');
    $admins->add_cap('delete_' . $this->type);
    $admins->add_cap('manage_' . $this->tax_type. 's');
    $admins->add_cap('edit_' . $this->tax_type. 's');
    $admins->add_cap('delete_' . $this->tax_type. 's');
    $admins->add_cap('assign_' . $this->tax_type. 's');

    // Права для отдела кадров
    $hrs = get_role('hr');
    if (!empty($hrs)) {
      $hrs->add_cap('read_' . $this->type);
      $hrs->add_cap('publish_' . $this->type);
      $hrs->add_cap('edit_' . $this->type .'s');
      $hrs->add_cap('edit_' . $this->type);
      $hrs->add_cap('edit_others_' . $this->type .'s');
      $hrs->add_cap('delete_' . $this->type .'s');
      $hrs->add_cap('delete_' . $this->type);
      $hrs->add_cap('manage_' . $this->tax_type. 's');
      $hrs->add_cap('edit_' . $this->tax_type. 's');
      $hrs->add_cap('delete_' . $this->tax_type. 's');
      $hrs->add_cap('assign_' . $this->tax_type. 's');
    }
  }

  /**
   * Устанавливает заголовк для соержимого поста при его редактировании
   */
  public function add_title_to_editor()
  {
    global $post;
    if (get_post_type($post) == $this->type) {
      echo '<script> jQuery("<h3>'. __('Описание вакансии') . '</h3>").insertBefore("#postdivrich");</script>';
    }
  }

  /**
   * Регистрирует новый мета-бокс для постов с помощью плагина ACF
   */
  public function register_post_acf()
  {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group([
        'key' => 'group_61b62bf7a7b74',
        'title' => 'Данные вакансии',
        'fields' => [
          [
            'key' => 'field_61b62c1932e85',
            'label' => 'Сумма заработной платы',
            'name' => 'wages',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
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
            'key' => 'field_61b62c8132e86',
            'label' => 'Регион вакансии',
            'name' => 'region',
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
            'key' => 'field_61b62cb632e87',
            'label' => 'Требуемый опыт работы',
            'name' => 'experience',
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
            'key' => 'field_61b62cee32e88',
            'label' => 'Тип занятости',
            'name' => 'employment',
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
            'key' => 'field_61b62dc682fc4',
            'label' => 'Ссылка на вакансию на сайте hh.ru',
            'name' => 'hh_url',
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
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'vacancy',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
      ]);

      acf_add_local_field_group(array(
        'key' => 'group_61b62e61326e2',
        'title' => 'Описание вакансии',
        'fields' => array(
          array(
            'key' => 'field_61b62e614e479',
            'label' => 'Должностные обязанности',
            'name' => 'duties',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
          ),
          array(
            'key' => 'field_61b62e6152171',
            'label' => 'Пожелания к кандидатам',
            'name' => 'suggestions',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
          ),
          array(
            'key' => 'field_61b62e6155ade',
            'label' => 'Мы предлагаем',
            'name' => 'offer',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'vacancy',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
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
    $new_columns = [];

    if (is_array($columns)) {
      foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key == 'taxonomy-department' && !isset($columns[$this->type . '-content'])) {
          $new_columns[$this->type . '-content'] = __('Описание вакансии');
          $new_columns[$this->type . '-data'] = __('Данные вакансии');
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
    switch ($column) {

      case $this->type . '-content':
        echo mb_substr($content = get_the_content(false, false, $post_id), 0, 140, 'utf-8');
        if (mb_strlen($content, 'utf-8') > 140) {
          echo '...';
        }
        break;

      case $this->type . '-data':
        if ($region = get_field('region', $post_id))
          echo '<p class="column-vacancy-data__item"><span class="dashicons dashicons-location-alt"></span><span>' . $region . '</span></p>';
        if ($wages = get_field('wages', $post_id))
          echo '<p class="column-vacancy-data__item"><span class="dashicons dashicons-tickets-alt"></span><span>' . $wages . '</span></p>';
        if ($experience = get_field('experience', $post_id))
          echo '<p class="column-vacancy-data__item"><span class="dashicons dashicons-welcome-learn-more"></span><span>' . $experience . '</span></p>';
        if ($employment = get_field('employment', $post_id))
          echo '<p class="column-vacancy-data__item"><span class="dashicons dashicons-clock"></span><span>' . $employment . '</span></p>';
    }
  }

  /**
   * Добавляет фильтр по дополнительным колонкам
   * @param WP_Post $post_type
   */
  public function filter_post_sortable_columns($post_type)
  {
    if ($post_type == $this->type) {
      $departments = get_terms([
        'taxonomy' => $this->tax_type,
        'hide_empty' => true,
      ]);

      $filter_department = (isset($_GET[$this->type . '_' . $this->tax_type])) ? $_GET[$this->type . '_' . $this->tax_type] : 0;

      $template = locate_template('templates/admin/filter-' . $this->type . '-' . $this->tax_type .'.php', false, false);

      include $template;
    }
  }

  /**
   * Фильтрует записи по таксономиям
   * @param $vars
   * @var $pagenow
   * @var  $post_type
   * @return mixed
   */
  public function posts_columns_filter_query($vars)
  {
    global $pagenow;
    global $post_type;

    if (!is_admin()) {
      return $vars;
    }

    // тут нужно указать все типы постов где нужен этот фильтр, например 'page','my_type_post' и т.д.
    $start_in_post_types = [$this->type];

    if (!empty($pagenow) && $pagenow == 'edit.php' && in_array($post_type, $start_in_post_types)) {
      if (!empty($_GET['filter_action']) && absint($_GET[$this->type . '_' . $this->tax_type]) > 0) {
        $vars['tax_query'] = [
          'relation' => 'AND',
          [
            'taxonomy'  => $this->tax_type,
            'field'     => 'id',
            'terms'     => absint($_GET[$this->type . '_' . $this->tax_type]),
          ]
        ];
      }
    }

    return $vars;
  }

  /**
   * Регистрирует опции настроек плагина для типов записи "doctor"
   */
  public function register_settings()
  {
    $keys = [
      'title_main',       // Заголовок раздела
      'description_main', // Описание раздела
      'footer_main',      // Описание в подвале раздела
      'form_id',          // ID CF7 формы обратной связи
      'response_id'       // ID CF7 формы отклика на вакансию
    ];

    foreach ($keys as $key) {
      $this->settings[$key] = get_option('theme_vacancy_' . $key);
      register_setting('theme_vacancy', 'theme_vacancy_' . $key);
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
      return (!empty($self->settings[$key])) ? $self->settings[$key] : get_option('theme_vacancy_' . $key);
    } else {
      return false;
    }
  }

  public static function get_department_vacancies($department, $count = -1)
  {
    $query = new WP_Query([
      'post_type'         => 'vacancy',
      'nopaging'          => true,
      'orderby'           => 'date',
      'order'             =>  'DESC',
      'posts_per_page'    => $count,
      'tax_query'         => [
        'relation'        => 'AND',
        [
          'taxonomy'      => 'department',
          'field'         => 'term_id',
          'terms'         => $department,
        ],
      ],
      'meta_query'        => [
        'relation'        => 'AND',
        [
          'key'           => 'wages',
          'value'         => '',
          'compare'       => '!=',
        ],
      ],
    ]);

    return ($query->have_posts()) ? $query : false;
  }
}
