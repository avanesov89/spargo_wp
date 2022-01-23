<?php
class Theme_Hooks_Menu
{
  public static function init()
  {
    $self = new self;
    // Кастомные классы для пунктов меню
    add_filter('nav_menu_css_class', [$self, 'filter_menu_css_class'], 10, 4);
    // Кастомные классы для ссылок меню
    add_filter( 'nav_menu_link_attributes', [$self, 'filter_menu_link_attributes'], 10, 4 );
  }

  /**
   * Кастомные классы для пунктов меню
   * @param $classes
   * @param $item
   * @param $args
   * @param $depth
   * @return array
   */
  public function filter_menu_css_class($classes, $item, $args, $depth)
  {
    switch ($args->theme_location) {
      case 'primary':
        $classes[] = 'header__menu-item';
        break;
      case 'footer_left':
      case 'footer_right':
        $classes[] = 'footer__list-item';
        break;
      case 'mobile':
        $classes[] = 'menu__item';
        break;
    }

    return $classes;
  }

  /**
   * Кастомные классы для пунктов меню
   * @param array $atts
   * @param WP_Post $item
   * @param stdClass $args
   * @param int $depth
   * @return array
   */
  public function filter_menu_link_attributes($atts, $item, $args, $depth)
  {
    switch ($args->theme_location) {
      case 'primary':
        $atts['class'] = 'header__menu-link';
        if ( in_array( 'current-menu-item', $item->classes) ) {
          $atts['class'] .= ' header__menu-link--active';
        }
        break;
      case 'footer_left':
      case 'footer_right':
        $atts['class'] = 'footer__list-link';
        break;
      case 'mobile':
        $atts['class'] = 'menu__link transition';
        break;
    }

    return $atts;
  }
}