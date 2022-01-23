<?php
use SVG\SVG;
use SVG\Nodes;
/**
 * Дополнительный функционал темы
 * @uses Theme_Autoload
 * @uses Theme_Init
 */
if (!class_exists('Theme_Autoload'))  require_once get_template_directory() . '/classes/class-theme-autoload.php';

// Автоматическая загрузка классов темы
Theme_Autoload::init();
// Установка темы
Theme_Init::init();
// Опции настройки темы
Theme_Customize::register();
// Хуки темы
Theme_Hooks::init();
Theme_Hooks_Menu::init();
// Шорткоды темы
Theme_Shortcodes::init();

// Загружает Ajax-события
Theme_Ajax::init();

// Дополнительные типы постов:
// - Баннеры
Theme_Posts_Banners::init();
// - Отзывы
Theme_Posts_Reviews::init();
// - Вакансии
Theme_Posts_Vacancy::init();
// - Услуги
Theme_Posts_Service::init();

// Дополнительные виджеты
// - Баннеры
Theme_Widget_Banners::init();
// - Новости
Theme_Widget_Posts::init();
// - Форма обратной связи
Theme_Widget_Action::init();
// - Отзывы
Theme_Widget_Reviews::init();
// - Документы
Theme_Posts_Document::init();
// - Партнеры
Theme_Posts_Partner::init();
// - Статьи технического блога
Theme_Posts_Dev_Post::init();
// - Решения (продукты)
Theme_Posts_App::init();

/**
 * Получает опции темы
 *
 * @param string $key
 * @param string $default
 * @return string|bool
 */
function theme_option($key, $default = '')
{
  $result = Theme_Customize::create()->get_option($key);
  return ($result) ? $result : $default;
}

/**
 * @param $image
 * @param false $raw
 * @param array $attr
 */
function theme_svg ($image, $raw = false, $attr = [])
{
  if ($raw) {
    $svg = SVG::fromFile($image);

    if (!empty($attr)) {
      $doc = $svg->getDocument();
      foreach ($attr as $key => $value) {
        $doc->setAttribute($key, $value);
      }
    }
    echo $svg;
  } else {
    echo '<svg><use xlink:href="' . THEME_ASSETS . 'img/min/sprite.svg#' . $image . '"></use></svg>';
  }
}