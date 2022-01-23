<?php

class Theme_Customize
{
  private static $instance;

  private $wp_customize;

  private $wp_customize_default_sections = [
    'title_tagline',
    'static_front_page'
  ];

  private $cf7_forms;

  public $options;

  public function __construct()
  {
    $this->options = get_theme_mods();

    $this->set_forms();
  }

  public function set_forms()
  {
    $cf7_args = ['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1];
    $cf7_forms = get_posts($cf7_args);

    $cf7_forms_choices = [
      '0' => __('Не используется'),
    ];

    foreach ($cf7_forms as $form) {
      $cf7_forms_choices[$form->ID] = $form->post_title;
    }

    $this->cf7_forms = $cf7_forms_choices;
  }

  /**
   * @return Theme_Customize
   */
  public static function create()
  {
    return (null === self::$instance) ? self::$instance = new self() : self::$instance;
  }

  /**
   * Возвращает опцию темы
   *
   * @param [type] $key
   * @return void
   */
  public function get_option($key)
  {
    return (isset($this->options[$key])) ? $this->options[$key] : false;
  }

  public static function register()
  {
    $self = new self;

    add_action('customize_register', [$self, 'init']);
  }

  /**
   * @param $wp_customize
   */
  public function init($wp_customize)
  {
    $this->wp_customize = $wp_customize;

    $this->section_title_tagline();

    $this->section_contacts();

    $this->section_front_page();

    $this->section_reviews();

    $this->section_documents();
  }

  /**
   * СЕКЦИЯ "СВОЙСТВА САЙТА"
   *
   * @return void
   */
  public function section_title_tagline()
  {
    // Опция: cookies_text
    $this->add_control_text('cookies_text', 'title_tagline', 'Нопоминание о cookies', 20, true);
  }

  /**
   * СЕКЦИЯ "КОНТАКТЫ"
   *
   * @return void
   */
  public function section_contacts()
  {
    $this->wp_customize->add_section('theme_opt_contacts', [
      'title'       => __('Контакты'),
      'description' => __('Контактная информация'),
      'priority'    => 30,
    ]);

    $pages = get_pages();
    $pages_choices = [
      0 => __('Не отображать'),
    ];
    foreach ($pages as $page) {
      $pages_choices[$page->ID] = $page->post_title;
    }


    // Опция: corp_address
    $this->add_control_text('corp_address', 'contacts', 'Адрес организации', 10, true);
    // Опция: corp_email_default
    $this->add_control_text('corp_email_default', 'contacts', 'Электронная почта (основная)', 11, false);
    // Опция: corp_email_support
    $this->add_control_text('corp_email_support', 'contacts', 'Электронная почта (поддержка)', 12, false);
    // Опция: corp_phone_mobile
    $this->add_control_text('corp_phone_mobile', 'contacts', 'Телефон мобильный', 13, false);
    // Опция: corp_phone_city
    $this->add_control_text('corp_phone_city', 'contacts', 'Телефон городской', 14, false);

    // Опция: social_vk
    $this->add_control_text('social_vk', 'contacts', 'Спарго технологии в вконтакте', 15);
    // Опция: social_facebook
    $this->add_control_text('social_facebook', 'contacts', 'Спарго технологии в фейсбук', 16);
    // Опция: social_odn
    $this->add_control_text('social_odn', 'contacts', 'Спарго технологии в одноклассниках', 17);
    // Опция: social_instagram
    $this->add_control_text('social_instagram', 'contacts', 'Спарго технологии в инстаграме', 18);
    // Опция: social_telegram
    $this->add_control_text('social_telegram', 'contacts', 'Спарго технологии в телеграм', 19);

    // Опция: copyright_start_year
    $this->add_control_text('copyright_start_year', 'contacts', 'Год начала в коирайте', 20);
    // Опция: copyright_sign
    $this->add_control_text('copyright_sign', 'contacts', 'Подпись в коирайте', 21);
    // Опция: personal_data_page
    $this->add_control_select('personal_data_page', 'contacts', 'Страница с правилами обработки ПДн', $pages_choices, 0, 22);
    // Опция: contacts_page
    $this->add_control_select('contacts_page', 'contacts', 'Страница контактов', $pages_choices, 0, 23);

    // Опция: callback_form
    $this->add_control_select('callback_form', 'contacts', 'Форма для обратного звонка', $this->cf7_forms, 0, 24);
  }

  /**
   * СЕКЦИЯ "ГЛАВНАЯ СТРАНИЦА"
   *
   * @return void
   */
  public function section_front_page()
  {
    // Опция: О нас
    $about_choices = [
      0 => __('Не отображать'),
    ];

    $about_choices_items = get_posts();
    foreach ($about_choices_items as $item) {
      $about_choices[$item->ID] = $item->post_title;
    }

    $this->add_control_select('about_home', 'static_front_page', 'О нас', $about_choices, 0, 12);

    // Опция: категория новостей на главной
    $categories_choices = [
      0 => __('Не отображать'),
    ];

    $categories = get_categories([
      'taxonomy'     => 'category',
      'type'         => 'post',
      'child_of'     => 0,
      'parent'       => '',
      'orderby'      => 'name',
      'order'        => 'ASC',
      'hide_empty'   => 0,
      'hierarchical' => 1,
      'pad_counts'   => false,
      // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
    ]);
    foreach ($categories as $term) {
      $categories_choices[$term->term_id] = $term->name;
    }
    $this->add_control_select('news_home', 'static_front_page', 'Категория новостей', $categories_choices, 0, 13);

    // Опция: количество новостей
    $this->add_control_text('news_home_limit', 'static_front_page', 'Количество новостей', 14, false);

    // Опция: количество вопросов
    $this->add_control_text('questions_home_limit', 'static_front_page', 'Количество вопросов', 15, false);
    $this->add_control_text('questions_home_title', 'static_front_page', 'Заголовок для вопросов', 16, false);
    $this->add_control_text('questions_home_description', 'static_front_page', 'Описание для вопросов', 17, true);

    // Опция: Баннеры нижние
    $this->add_control_select('slider_home_bottom', 'static_front_page', 'Баннеры нижние', $slider_choices, 0, 21);

    // Опция: Код карты
    $this->add_control_code('footer_map_code', 'static_front_page', 'Код карты в подвале', 99);
  }

  /**
   * СЕКЦИЯ "ОТЗЫВЫ"
   */
  public function section_reviews()
  {
    $this->wp_customize->add_section('theme_opt_reviews', [
      'title'       => __('Отзывы'),
      'priority'    => 40,
    ]);
    // Опция: reviews_main_title
    $this->add_control_text('reviews_main_title', 'reviews', 'Заголовок страницы с отзывами', 10, false);
    // Опция: reviews_main_description
    $this->add_control_text('reviews_main_description', 'reviews', 'Описание страницы с отзывами', 11, true);
    // Опция: reviews_per_page
    $this->add_control_text('reviews_per_page', 'reviews', 'Количество отзывов на странице', 12, false);
  }

  /**
   * СЕКЦИЯ "ДОКУМЕНТЫ"
   */
  public function section_documents()
  {
    $this->wp_customize->add_section('theme_opt_documents', [
      'title'       => __('Документы'),
      'priority'    => 50,
    ]);
    // Опция: documents_main_title
    $this->add_control_text('documents_main_title', 'documents', 'Заголовок страницы с документами', 10, false);
    // Опция: documents_main_description
    $this->add_control_text('documents_main_description', 'documents', 'Описание страницы с документами', 11, true);
  }

  public function section_security()
  {
    $this->wp_customize->add_section('theme_opt_security', [
      'title'       => __('Безопасность'),
      'priority'    => 50,
    ]);

    $this->add_control_text('recaptha_key', 'security', 'Ключ сайта', 10, false);
    $this->add_control_text('recaptha_secret', 'security', 'Секретный ключ', 11, false);
  }

  private function section_prepare($section)
  {
    return (!in_array($section, $this->wp_customize_default_sections)) ? 'theme_opt_' . $section : $section;
  }

  /**
   * Добавляет текстовую опцию
   * @param $name
   * @param $section
   * @param $title
   * @param int $priority
   * @param false $multiline
   */
  private function add_control_text($name, $section, $title, $priority = 10, $multiline = false)
  {
    $wp_customize_section = $this->section_prepare($section);

    $this->wp_customize->add_setting('theme_mods_' . THEME_NAME . '[' . $name . ']', [
      'capability' => 'edit_theme_options',
      'type' => 'option',
    ]);

    $this->wp_customize->add_control('theme_opt_' . $section . '_' . $name, [
      'label' => __($title, THEME_NAME),
      'section' => $wp_customize_section,
      'settings' => 'theme_mods_' . THEME_NAME . '[' . $name . ']',
      'type' => ($multiline) ? 'textarea' : 'text',
      'priority' => $priority
    ]);
  }

  /**
   * Добавляет html/code опцию
   * @param $name
   * @param $section
   * @param $title
   * @param int $priority
   */
  private function add_control_code($name, $section, $title, $priority = 10)
  {
    $wp_customize_section = $this->section_prepare($section);

    $this->wp_customize->add_setting('theme_mods_' . THEME_NAME . '[' . $name . ']', [
      'capability' => 'edit_theme_options',
      'type' => 'option',
    ]);

    $this->wp_customize->add_control(new WP_Customize_Code_Editor_Control($this->wp_customize, 'theme_opt_' . $section . '_' . $name, [
      'label'     => __($title),
      'section'   => $wp_customize_section,
      'settings'  => 'theme_mods_' . THEME_NAME . '[' . $name . ']',
      'priority'  => $priority,
    ]));
  }

  /**
   * Добавляет опцию выпадающего списка
   *
   * @param [type] $name: имя опции
   * @param [type] $section: имя секции
   * @param [type] $title: заголовок опции
   * @param [type] $choices
   * @param array $default
   * @param integer $priority
   * @return void
   */
  private function add_control_select($name, $section, $title, $choices, $default = [], $priority = 10)
  {
    $wp_customize_section = $this->section_prepare($section);

    $this->wp_customize->add_setting('theme_mods_' . THEME_NAME . '[' . $name . ']', [
      'capability'  => 'edit_theme_options',
      'type'        => 'option',
      'default'     => $default,
    ]);

    $this->wp_customize->add_control('theme_opt_' . $section . '_' . $name, [
      'label'     => __($title),
      'section'   => $wp_customize_section,
      'settings'  => 'theme_mods_' . THEME_NAME . '[' . $name . ']',
      'type'      => 'select',
      'choices'   => $choices,
      'priority'  => $priority
    ]);
  }

  /**
   * Добавляет опцию выбора изображения
   *
   * @param [type] $name
   * @param [type] $section
   * @param [type] $title
   * @param integer $priority
   * @return void
   */
  private function add_control_image($name, $section, $title, $priority = 10)
  {
    $wp_customize_section = $this->section_prepare($section);

    $this->wp_customize->add_setting('theme_mods_' . THEME_NAME . '[' . $name . ']', [
      'capability' => 'edit_theme_options',
      'type' => 'option',
      'transport' => 'refresh',
      'height'    => 100,
    ]);

    $this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'theme_opt_' . $section . '_' . $name, [
      'label'     => __($title),
      'section'   => $wp_customize_section,
      'settings'  => 'theme_mods_' . THEME_NAME . '[' . $name . ']',
    ]));
  }

}
