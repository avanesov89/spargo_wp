<?php
class Theme_Init
{
  public function __construct()
  {
  }

  public static function init()
  {
    $self = new self;

    // Предупреждение о зависимостях темы
    add_action('admin_notices', [$self, 'theme_dependencies']);

    // Установка парарметров темы
    add_action('after_setup_theme', [$self, 'install']);

    // Позиции для виджетов
    add_action('widgets_init', [$self, 'widgets']);

    // Убирает отступ html при отображении админ-бара
    add_action('wp_enqueue_scripts', [$self, 'adminbar_remove_margin']);

    // Загружает стили и скрипты темы
    add_action('wp_enqueue_scripts', [$self, 'layouts']);

    // Загружает стили и скрипты админки
    add_action('admin_enqueue_scripts', [$self, 'layouts_admin']);
  }

  /**
   * Предупреждение о зависимостях темы
   *
   * @return void
   */
  public function theme_dependencies()
  {
    $plugins = json_decode(file_get_contents(THEME_DIR . 'plugins.json'), true);

    if (!function_exists('plugin_function') && !empty($plugins)) {
      foreach ($plugins as $name => $plugin) {
        if (!is_plugin_active($plugin['path'])) {
          $action = 'install-plugin';
          $url = wp_nonce_url(
            add_query_arg(
              array(
                'action' => $action,
                'plugin' => $plugin['key']
              ),
              admin_url('update.php')
            ),
            $action . '_' . $plugin['key']
          );

          echo '<div class="error noty-flex"><p>' . __('Внимание: для правильной работы темы необходимо установить плагин', THEME_NAME) . ' <b>' . $name . '</b>' .
            '</p><a class="button button-primary" href="' . $url . '">' . __('Установить', THEME_NAME) . '</a></div>';
        }
      }
    }
  }

  /**
   * Инициализация параметров темы
   *
   * @return void
   */
  public function install()
  {
    load_theme_textdomain(THEME_NAME, get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(650, 510, true);

    add_image_size('full_screen', 1920, 9999, false);

    add_theme_support('html5', [
      'comment-form',
      'comment-list',
      'caption',
    ]);

    // Форматы записей
    add_theme_support('post-formats', [
      'banners',
      'doctors',
      'services',
      'questions'
    ]);

    // Лого сайта
    add_theme_support('custom-logo', [
      'width'       => 190,
      'height'      => 54,
      'flex-width'  => true,
      'flex-height' => true,
      'header-text' => false
    ]);

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for Block Styles.
    add_theme_support('wp-block-styles');

    // Add support for full and wide align images.
    add_theme_support('align-wide');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Enqueue editor styles.
    add_editor_style('style-editor.css');

    // Добавляет поддержку темой плагина WooCommerce
    add_theme_support('woocommerce', [
      'gallery_thumbnail_image_width' => 305,
    ]);

    // Убирает админ-бар для не администраторов
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }

    // Области меню
    register_nav_menus([
      'primary' => __('Основное меню'),
      'footer_left' => __('В подвале слева'),
      'footer_right' => __('В подвале справа'),
      'mobile' => __('Мобильное меню'),
    ]);

  }

  /**
   * Инициализация позиций для вывода виджетов
   *
   * @return void
   */
  public function widgets()
  {
    register_sidebar([
      'name'  => __('Главная страница'),
      'id'    => 'home',
      'class'       => 'main__widgets',
      'before_widget' => '<div id="%1$s" class="main__widgets-block %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => false,
      'after_title'   => false,
      'before_sidebar' => false,
      'after_sidebar'  => false,
    ]);

    register_sidebar([
      'name'  => __('Колонка магазина'),
      'id'    => 'shop',
      'class'       => 'widgets',
      'before_widget' => '<div id="%1$s" class="filter__main-block %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="filter__main-title">',
      'after_title'   => '</div>',
      'before_sidebar' => '<div class="filter__main">',
      'after_sidebar'  => '</div>',
    ]);
  }

  /**
   * Убирает отступ html при отображении админ-бара
   *
   * @return void
   */
  public function adminbar_remove_margin()
  {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }

  /**
   * Загружает стили и скрипты темы
   *
   * @return void
   */
  public function layouts()
  {
    $ver = wp_get_theme()->get('Version');

    # GOOGLE FONTS
    $query_args = [
      'family'   => 'Montserrat:wght@400;600;700;900&family=Open+Sans:wght@400;600;700',
      'display'  => 'swap',
      'subset'   => 'cyrillic',
    ];
    //wp_enqueue_style('google-fonts', add_query_arg($query_args, "//fonts.googleapis.com/css" ), [], null);

    // STYLESHEETS
    wp_enqueue_style('vendor', THEME_ASSETS . 'css/vendor.css', null, $ver);
    wp_enqueue_style('main', THEME_ASSETS . 'css/main.css', ['vendor'], $ver);
    wp_enqueue_style('slick', THEME_ASSETS . 'css/slick.css', ['main'], $ver);
    wp_enqueue_style('custom', THEME_ASSETS . 'css/custom.css', null, $ver);
    wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css', null, '4.0');

    // SCRIPTS
    if (!is_admin()) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', false, '3.5.1', true);
      wp_enqueue_script('jquery');
    }

    wp_enqueue_script('vendor', THEME_ASSETS . 'js/final_vendor.min.js', ['jquery'], $ver, true);
    wp_enqueue_script('main', THEME_ASSETS . 'js/final_main.min.js', ['jquery', 'vendor'], $ver, true);
    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js', ['jquery'], '4.0', true);


    wp_localize_script('main', 'theme_ajax', [
      'url' => admin_url('admin-ajax.php')
    ]);
  }

  /**
   * Функия для ассинхронной загрузки скриптов
   */
  public function add_async_attribute($tag, $handle)
  {
    if ('recaptha' !== $handle)
      return $tag;
    return str_replace(' src', ' async="async" src', $tag);
  }

  /**
   * Дополнительные стили и скрипты для админки
   *
   * @return void
   */
  public function layouts_admin()
  {
    $ver = wp_get_theme()->get('Version');
    wp_enqueue_style('theme_admin', THEME_ASSETS . 'css/admin.css', [], $ver);
  }
}
