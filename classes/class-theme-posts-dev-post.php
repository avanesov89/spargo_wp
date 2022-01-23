<?php
class Theme_Posts_Dev_Post
{
  private static $instance;

  public $labels;

  public $args;

  public $type = 'dev_post';

  public $tax_type = 'dev_category';

  public $tag_type = 'dev_tag';

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
      'name'                  => __('Статьи'),  // основное название для типа записи
      'singular_name'         => __('Статья'),  // название для одной записи этого типа
      'add_new'               => __('Добавить статью'), // для добавления новой записи
      'add_new_item'          => __('Новая статья'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать статью'), // для редактирования типа записи
      'new_item'              => __('Новая статья'),  // текст новой записи
      'view_item'             => __('Просмотр статьи'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск статьи'), // для поиска по этим типам записи
      'not_found'             => __('Нет статей'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Технический блог'),  // название меню
      'archives'              => __('Технический блог'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Статья'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Изображение статьи'),  // изображение записи
      'set_featured_image'    => __('Загрузить изображение статьи'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить изображение статьи'),  // Удалить изображение записи
    ];

    // Ярлыки для таксономий
    $self->labels['tax'] = [
      'name'                  => __('Категории'),
      'singular_name'         => __('Категория'),
      'all_items'             => __('Все категории'),
      'edit_item'             => __('Редактировать категорию'),
      'update_item'           => __('Обновить категорию'),
      'add_new_item'          => __('Создать категорию'),
      'new_item_name'         => __('Категория'),
      'choose_from_most_used' => __('Выбрать из наиболее популярных категорий'),
    ];

    // Ярлыки для меток
    $self->labels['tag'] = [
      'name'                        => __('Технологии'),
      'singular_name'               => __('Технология'),
      'search_items'                =>  __( 'Поиск технологий' ),
      'popular_items'               => __( 'Популярные технологии' ),
      'all_items'                   => __( 'Все технологии' ),
      'parent_item'                 => null,
      'parent_item_colon'           => null,
      'edit_item'                   => __( 'Редактировать технологию' ),
      'update_item'                 => __( 'Обновить технологию' ),
      'add_new_item'                => __( 'Новая технология' ),
      'new_item_name'               => __( 'Заголовок новой технологии' ),
      'separate_items_with_commas'  => __( 'Разделять технологии запятыми' ),
      'add_or_remove_items'         => __( 'Добавить или удалить технологии' ),
      'choose_from_most_used'       => __( 'Выбрать из наиболее популярных технологий' ),
      'menu_name'                   => __( 'Технологии' ),
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Статьи'),
      'labels'                => $self->labels['post'],
      'description'           => __('Технический блог'),
      'public'                => true,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => true,
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-shortcode',
      'capability_type'       => 'post',
      'supports'              => ['author', 'comments', 'title', 'editor', 'excerpt', 'thumbnail'],
      'query_var'             => true,
      'taxonomies'            => [$self->tax_type, $self->tag_type],
      'rewrite'               => ['slug' => 'dev'],
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
      'rewrite'           => ['slug' => 'dev-category'],
      'sort'              => 'order',
      'capabilities'      => [
        'manage_terms'  => 'manage_' . $self->tax_type. 's',
        'edit_terms'    => 'edit_' . $self->tax_type. 's',
        'delete_terms'  => 'delete_' . $self->tax_type. 's',
        'assign_terms'  => 'assign_' . $self->tax_type. 's',
      ]
    ];

    // Аргументы для регистрации меток для нового типа постов
    $self->args['tag'] = [
      'labels'        => $self->labels['tag'],
      'public'                => true,
      'hierarchical'          => false,
      'show_admin_column'     => true,
      'query_var'             => true,
      'update_count_callback' => '_update_post_term_count',
      'rewrite'               => ['slug' => 'dev-tag'],
      'capabilities'          => [
        'manage_terms'        => 'manage_' . $self->tag_type. 's',
        'edit_terms'          => 'edit_' . $self->tag_type. 's',
        'delete_terms'        => 'delete_' . $self->tag_type. 's',
        'assign_terms'        => 'assign_' . $self->tag_type. 's',
      ]
    ];

    // Регистрирует новый тип постов
    add_action('init', [$self, 'register_post_type']);

    // Регистрирует новый тип таксономии для постов (рубрики)
    add_action('init', [$self, 'register_post_taxonomy']);

    // Регистрирует новый тип меток для постов (теги)
    add_action('init', [$self, 'register_post_tag']);

    // Устанавливает права доступа для управлениями записями
    add_action('admin_init', [$self, 'set_post_caps']);
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
   * Регистрирует новый тип меток для постов (теги)
   */
  public function register_post_tag()
  {
    register_taxonomy($this->tag_type, [$this->tag_type], $this->args['tag']);
    register_taxonomy_for_object_type($this->tag_type, $this->type);
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
    $admins->add_cap('manage_' . $this->tag_type. 's');
    $admins->add_cap('edit_' . $this->tag_type. 's');
    $admins->add_cap('delete_' . $this->tag_type. 's');
    $admins->add_cap('assign_' . $this->tag_type. 's');

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
      $editor->add_cap('manage_' . $this->tag_type. 's');
      $editor->add_cap('edit_' . $this->tag_type. 's');
      $editor->add_cap('delete_' . $this->tag_type. 's');
      $editor->add_cap('assign_' . $this->tag_type. 's');
    }
  }
}