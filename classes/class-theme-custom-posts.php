<?php

class Theme_Custom_Posts
{
  public function __construct()
  {
  }

  /**
   * Сохраняет мета-данные постов
   *
   * @param [type] $post_id
   * @param [type] $post
   * @param [type] $post_type
   * @param [type] $nonce
   * @return void
   */
  public static function save_post_meta($post_id, $post, $post_type, $post_data, $nonce_action)
  {
    // Обрабатывает только посты типа banner
    if ($post->post_type != $post_type) {
      return $post_id;
    }
    // проверка
    if (isset($post_data['extra_fields_nonce'])) {
      if (!wp_verify_nonce($post_data['extra_fields_nonce'], $nonce_action)) return false;
    }
    // выходим если это автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
    // выходим если юзер не имеет право редактировать запись
    if (!current_user_can('edit_post', $post_id)) return false;
    // выходим если данных нет
    if (!isset($post_data['extra'])) return false;

    // Все ОК! Теперь, нужно сохранить/удалить данные
    // чистим все данные от пробелов по краям
    $post_data['extra'] = array_map('trim', $post_data['extra']);
    foreach ($post_data['extra'] as $key => $value) {
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

  public static function show_pending_posts($menu, $post_type, $post_status = 'pending')
  {
    $num_posts = wp_count_posts($post_type, 'readable');
    $pending_count = 0;
    if (!empty($num_posts->$post_status))
      $pending_count = $num_posts->$post_status;

    // build string to match in $menu array
    if ($post_type == 'post') {
      $menu_str = 'edit.php';
      // support custom post types
    } else {
      $menu_str = 'edit.php?post_type=' . $post_type;
    }

    // loop through $menu items, find match, add indicator
    foreach ($menu as $menu_key => $menu_data) {
      if ($menu_str != $menu_data[2])
        continue;
      $menu[$menu_key][0] .= " <span class='update-plugins count-$pending_count'><span class='plugin-count'>" . number_format_i18n($pending_count) . '</span></span>';
    }
    return $menu;
  }
}
