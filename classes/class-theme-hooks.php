<?php
class Theme_Hooks
{
  public static function init()
  {
    $self = new self;

    // Хлебные крошки
    add_action('breadcrumbs', [$self, 'show_breadcrumbs'], 10);

    // Отображение новостей
    add_action('news_end', [$self, 'view_news_end'], 10);

    // Убирает ярлыки в заголовках записей
    add_filter('get_the_archive_title', [$self, 'filter_get_the_archive_title']);

    // Количество отзывов на странице архива
    add_filter( 'pre_get_posts', [$self, 'change_reviews_posts_per_page'] );

    // Вывод отзывов на странице архива
    add_filter( 'pre_get_posts', [$self, 'filter_documents_archive_posts'] );

    // Вывод партнеров на странице архива
    add_filter( 'pre_get_posts', [$self, 'filter_partners_archive_posts'] );

    // Вывод постов из категории "Актуально"
    add_filter( 'pre_get_posts', [$self, 'filter_actual_category_posts'] );

    // Исключает определенные страницы из поиска
    add_action( 'pre_get_posts', [$self, 'pages_search_filter'] );

    // Заголовок страницы 404
    add_filter('wp_title', [$self, 'filter_404_title']);
  }

  /**
   * Хлебные крошки
   * @param $args
   */
  public function show_breadcrumbs($args)
  {
    get_template_part('templates/partials/breadcrumbs', null, $args);
  }

  public function view_news_end($args)
  {
    if (!empty($args['layout'])) {
      if (absint($args['term_id']) > 0) {
        $term = get_term($args['term_id']);
      } else {
        $term = false;
      }

      get_template_part('templates/partials/widget-news-' . $args['layout'], 'end', ['term' => $term, 'label' => $args['label']]);
    }
  }

  /**
   * Убирает ярлыки в заголовках записей
   * @param string $title
   * @return string
   */
  public function filter_get_the_archive_title($title)
  {
    if (is_category()) {
      $title = single_cat_title('', false);
    } elseif (is_tag()) {
      $title = single_tag_title('', false);
    } elseif (is_author()) {
      $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
      $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
      $title = post_type_archive_title('', false);
    }
    return $title;
  }

  /**
   * Количество отзывов на странице архива
   * @param $query
   * @return WP_Query
   */
  public function change_reviews_posts_per_page( $query )
  {
    if ( $query->is_post_type_archive( 'review' ) && ! is_admin() && $query->is_main_query() ) {
      $per_page = (absint(theme_option('reviews_per_page')) > 0) ? absint(theme_option('reviews_per_page')) : 5;
      $query->set( 'posts_per_page', $per_page );
    }

    return $query;
  }

  /**
   * Вывод отзывов на странице архива
   * @param $query
   * @return WP_Query
   */
  public function filter_documents_archive_posts($query)
  {
    if ( $query->is_post_type_archive('document') && ! is_admin() && $query->is_main_query() ) {
      $query->set( 'nopaging', true );
      $query->set('meta_query', [
        'relation'        => 'AND',
        [
          'key'           => '_thumbnail_id',
          'value'         => '',
          'compare'       => '!=',
        ],
      ]);
    }
    return $query;
  }

  /**
   * Вывод партнеров на странице архива
   * @param $query
   * @return WP_Query
   */
  public function filter_partners_archive_posts($query)
  {
    if ( $query->is_post_type_archive( 'partner' ) && ! is_admin() && $query->is_main_query() ) {
      $per_page = (absint(Theme_Posts_Partner::get_option('per_page')) > 0) ? absint(Theme_Posts_Partner::get_option('per_page')) : 12;
      $query->set( 'posts_per_page', $per_page );
    }

    return $query;
  }

  /**
   * Вывод постов из категории "Актуально"
   * @param $query
   * @return mixed
   */
  public function filter_actual_category_posts($query)
  {
    if ($query->is_category && $query->query_vars['category_name'] == 'actual' && ! is_admin() && $query->is_main_query()) {
      $query->set( 'posts_per_page', 9 );
    }

    return $query;
  }

  /**
   * Исключает определенные страницы из поиска
   * @param $query
   * @return mixed
   */
  public function pages_search_filter($query)
  {
    if ( ! $query->is_admin && $query->is_search && $query->is_main_query() ) {
      $query->set( 'post__not_in', [193, 304]);
    }

    if ( ! $query->is_admin && $query->is_author && $query->is_main_query() ) {
      $query->set( 'post_type', 'dev_post');
    }

    return $query;
  }

  /**
   * Заголовок страницы 404
   * @param $title
   * @return string|void
   */
  public function filter_404_title( $title )
  {
    if ( is_404() ) {
      $title = __('Страница не найдена');
    }

    return $title;
  }
}