<?php
$custom_logo_id = (has_custom_logo()) ? get_theme_mod('custom_logo') : false;
$custom_logo_src = ($custom_logo_id) ? wp_get_attachment_image_src($custom_logo_id, 'full') : false;
$custom_logo_type = ($custom_logo_src) ? wp_check_filetype($custom_logo_src[0]) : false;

$blog_description = (get_bloginfo('description')) ? get_bloginfo('description') : __('IT-решения для автоматизации бизнес-процессов');
$blog_description_arr = preg_split('/\s+/', $blog_description);
$blog_description_loc = '';

foreach ($blog_description_arr as $word=>$text) {
  if ($word == 0) {
    $blog_description_loc .= $text;
  } elseif ($word == 3) {
    $blog_description_loc .= '<br>' . $text;
  } else {
    $blog_description_loc .= ' ' . $text;
  }
}
?>

<div class="header__main">
  <div class="container">
    <div class="header__logo">
      <a href="/" class="header__logo-link" title="<?php esc_attr(get_bloginfo('name')); ?>" <?php if ( has_custom_logo() ): ?>style="background-image: url(<?php echo $custom_logo_src[0]; ?>)"<?php endif; ?>>
        <span><?php echo $blog_description_loc; ?></span>
      </a>
    </div>

    <?php wp_nav_menu([
      'container'       => 'nav',
      'container_class' => 'header__nav',
      'theme_location'  => 'primary',
      'menu_class'      => 'header__menu list-reset',
    ]); ?>

    <button class="header__search-button">
      <svg class="header__search">
        <use xlink:href="<?php esc_attr_e(THEME_ASSETS); ?>img/min/sprite.svg#search_icon"></use>
      </svg>
    </button>

    <div class="header__adaptive m-menu">
      <a href="javascript:void(0);" class="menu-trigger">
        <svg>
          <use xlink:href="<?php esc_attr_e(THEME_ASSETS); ?>img/min/sprite.svg#adaptive_menu"></use>
        </svg>
      </a>
    </div>
  </div>

</div>

<?php get_search_form(); ?>