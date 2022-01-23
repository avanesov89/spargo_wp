<?php
/**
 * Шаблон настройки товаров
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

$sliders = get_terms('slider', ['hide_empty' => false]);
$sliders_choices = [
  '0' => __('Не используется'),
];
foreach ($sliders as $slider) {
  $sliders_choices[$slider->term_id] = $slider->name;
}
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php _e('Настройки товаров'); ?></h1>

  <form id="theme_save_app_options" action="options.php" method="post">
    <?php
    settings_fields('theme_app');
    do_settings_sections('theme_app');
    ?>
    <table class="form-table" role="presentation">
      <tbody>
      <tr>
        <th scope="row"><label for="main_title"><?php _e('Заголовок страницы с продуктами'); ?></label></th>
        <td>
          <input type="text" id="main_title" name="theme_app_main_title" class="widefat" value="<?php echo $args['main_title']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="pre_title"><?php _e('Заголовок перед списком продуктов'); ?></label></th>
        <td>
          <input type="text" id="pre_title" name="theme_app_pre_title" class="widefat" value="<?php echo $args['pre_title']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="main_description"><?php _e('Описание страницы с продуктами'); ?></label></th>
        <td>
          <?php wp_editor( $args['main_description'], 'theme_app_main_description', [
            'media_buttons' => 0,
            'textarea_name' => 'theme_app_main_description',
            'textarea_rows' => 8,
          ] ); ?>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="per_page"><?php _e('Количество записей на странице'); ?></label></th>
        <td>
          <input type="text" id="per_page" name="theme_app_per_page" class="widefat" value="<?php echo $args['per_page']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="form_id"><?php _e('Форма запроса демо версии продукта'); ?></label></th>
        <td>
          <select id="form_id" name="theme_app_form_id" class="widefat">
            <?php foreach ($cf7_forms_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['form_id']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="industry_slider"><?php _e('Сдайдер с баннерами отраслевых решений'); ?></label></th>
        <td>
          <select id="industry_slider" name="theme_app_industry_slider" class="widefat">
            <?php foreach ($sliders_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['industry_slider']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="faq_slider"><?php _e('Сдайдер с с вопросами и ответами'); ?></label></th>
        <td>
          <select id="faq_slider" name="theme_app_faq_slider" class="widefat">
            <?php foreach ($sliders_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['faq_slider']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="clients_slider"><?php _e('Сдайдер "Крупные сети"'); ?></label></th>
        <td>
          <select id="clients_slider" name="theme_app_clients_slider" class="widefat">
            <?php foreach ($sliders_choices as $id => $name): ?>
              <option value="<?php echo absint($id); ?>" <?php selected(absint($args['clients_slider']), absint($id)); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      </tbody>
    </table>

    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Сохранить изменения'); ?>"></p>

  </form>
</div>

