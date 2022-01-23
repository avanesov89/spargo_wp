<?php
/**
 * Шаблон настройки вакансий
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
  <h1 class="wp-heading-inline"><?php _e('Настройки вакансий'); ?></h1>

  <form id="theme_save_vacancy_options" action="options.php" method="post">
    <?php
    settings_fields('theme_vacancy');
    do_settings_sections('theme_vacancy');
    ?>
    <h2 class="title"><?php _e('Главная страница раздела'); ?></h2>
    <table class="form-table" role="presentation">
      <tbody>
      <tr>
        <th scope="row"><label for="title_main"><?php _e('Заголовок раздела '); ?></label></th>
        <td>
          <input type="text" id="title_main" name="theme_vacancy_title_main" class="widefat" value="<?php echo $args['title_main']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="description_main"><?php _e('Описание раздела'); ?></label></th>
        <td>
          <?php wp_editor( $args['description_main'], 'theme_vacancy_description_main', [
              'media_buttons' => 0,
              'textarea_name' => 'theme_vacancy_description_main',
              'textarea_rows' => 8,
          ] ); ?>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="footer_main"><?php _e('Подпись в подвале раздела'); ?></label></th>
        <td>
          <?php wp_editor( $args['footer_main'], 'theme_vacancy_footer_main', [
              'media_buttons' => 0,
              'textarea_name' => 'theme_vacancy_footer_main',
              'textarea_rows' => 8,
          ] ); ?>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="form_id"><?php _e('Форма для отправки резюме'); ?></label></th>
        <td>
          <select id="form_id" name="theme_vacancy_form_id" class="widefat">
            <?php foreach ($cf7_forms_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['form_id']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="response_id"><?php _e('Форма для отклика на вакансию'); ?></label></th>
        <td>
          <select id="response_id" name="theme_vacancy_response_id" class="widefat">
            <?php foreach ($cf7_forms_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['response_id']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      </tbody>
    </table>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Сохранить изменения'); ?>"></p>
  </form>
</div>
