<?php
/**
 * Шаблон настройки партнеров
 * @var $args
 */
$cf7_args = ['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1];
$cf7_forms = get_posts($cf7_args);

$cf7_forms_choices = [
  '0' => __('Не используется'),
];

foreach ($cf7_forms as $form) {
  $cf7_forms_choices[$form->ID] = $form->post_title;
}
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php _e('Настройки партнеров'); ?></h1>

  <form id="theme_save_partners_options" action="options.php" method="post">
    <?php
    settings_fields('theme_partners');
    do_settings_sections('theme_partners');
    ?>
    <table class="form-table" role="presentation">
      <tbody>
      <tr>
        <th scope="row"><label for="main_title"><?php _e('Заголовок страницы с партнерами'); ?></label></th>
        <td>
          <input type="text" id="main_title" name="theme_partners_main_title" class="widefat" value="<?php echo $args['main_title']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="pre_title"><?php _e('Заголовок перед описанием'); ?></label></th>
        <td>
          <input type="text" id="pre_title" name="theme_partners_pre_title" class="widefat" value="<?php echo $args['pre_title']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="main_description"><?php _e('Описание страницы с партнерами'); ?></label></th>
        <td>
          <?php wp_editor( $args['main_description'], 'theme_partners_main_description', [
            'media_buttons' => 0,
            'textarea_name' => 'theme_partners_main_description',
            'textarea_rows' => 8,
          ] ); ?>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="per_page"><?php _e('Количество записей на странице'); ?></label></th>
        <td>
          <input type="text" id="per_page" name="theme_partners_per_page" class="widefat" value="<?php echo $args['per_page']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="footer_title"><?php _e('Заголовок в подвале'); ?></label></th>
        <td>
          <input type="text" id="footer_title" name="theme_partners_footer_title" class="widefat" value="<?php echo $args['footer_title']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="footer_description"><?php _e('Описание в подвале'); ?></label></th>
        <td>
          <?php wp_editor( $args['footer_description'], 'theme_partners_footer_description', [
            'media_buttons' => 0,
            'textarea_name' => 'theme_partners_footer_description',
            'textarea_rows' => 8,
          ] ); ?>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="footer_button"><?php _e('Текст кнопки вызова формы'); ?></label></th>
        <td>
          <input type="text" id="footer_button" name="theme_partners_footer_button" class="widefat" value="<?php echo $args['footer_button']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="form_id"><?php _e('Форма обратной связи'); ?></label></th>
        <td>
          <select id="form_id" name="theme_partners_form_id" class="widefat">
            <?php foreach ($cf7_forms_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['form_id']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      </tbody>
    </table>

    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Сохранить изменения'); ?>"></p>

  </form>
</div>
