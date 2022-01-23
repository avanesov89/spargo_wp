<?php
class Theme_Posts_Document
{
  private static $instance;

  public $labels;

  public $args;

  public $type = 'document';

  /**
   * Создает экземпляр класса
   * @return Theme_Posts_Document
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
      'name'                  => __('Документы'),  // основное название для типа записи
      'singular_name'         => __('Документ'),  // название для одной записи этого типа
      'add_new'               => __('Добавить документ'), // для добавления новой записи
      'add_new_item'          => __('Новый документ'), // заголовка у вновь создаваемой записи в консоли.
      'edit_item'             => __('Редактировать документ'), // для редактирования типа записи
      'new_item'              => __('Новый документ'),  // текст новой записи
      'view_item'             => __('Просмотр документа'), // для просмотра записи этого типа.
      'search_items'          => __('Поиск документа'), // для поиска по этим типам записи
      'not_found'             => __('Нет документов'), // если в результате поиска ничего не было найдено
      'not_found_in_trash'    => __('Не найдено в корзине'), // если не было найдено в корзине
      'menu_name'             => __('Документы'),  // название меню
      'archives'              => __('Лицензии и сертификаты'),  // заголовок в архиве записей
      'name_admin_bar'        => __('Документ'),  // заголовк в меню "Дбавить" админ-бара
      'featured_image'        => __('Изображение документа'),  // изображение записи
      'set_featured_image'    => __('Загрузить изображение документа'),  // Установить изображение записи
      'remove_featured_image' => __('Удалить изображение документа'),  // Удалить изображение записи
    ];

    // Аргументы для регистрации нового типа постов
    $self->args['post'] = [
      'label'                 => __('Документы'),
      'labels'                => $self->labels['post'],
      'description'           => __('Лицензии и сертификаты'),
      'public'                => false,
      'show_in_nav_menus'     => true,
      'show_ui'               => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'hierarchical'          => false,
      'has_archive'           => 'documents',
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-format-aside',
      'capability_type'       => $self->type,
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

    // Настройка колонок для списка записей в админке
    add_filter('manage_' . $self->type . '_posts_columns', [$self, 'custom_post_columns']);

    // Содержимое кастомных колонок для списка записей в админке
    add_action('manage_' . $self->type . '_posts_custom_column', [$self, 'custom_post_columns_content'], 10, 2);
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