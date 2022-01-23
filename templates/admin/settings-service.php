<?php
/**
 * Шаблон настройки услуг
 * @var $args
 */
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php _e('Настройки услуг'); ?></h1>

  <form id="theme_save_service_options" action="options.php" method="post">
    <?php
    settings_fields('theme_service');
    do_settings_sections('theme_service');
    ?>
    <table class="form-table" role="presentation">
      <tbody>
      <tr>
        <th scope="row"><label for="main_title"><?php _e('Заголовок страницы с услугами'); ?></label></th>
        <td>
          <input type="text" id="main_title" name="theme_service_main_title" class="widefat" value="<?php echo $args['main_title']; ?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="main_description"><?php _e('Описание страницы с услугами'); ?></label></th>
        <td>
          <?php wp_editor( $args['main_description'], 'theme_service_main_description', [
            'media_buttons' => 0,
            'textarea_name' => 'theme_service_main_description',
            'textarea_rows' => 8,
          ] ); ?>
        </td>
      </tr>

      </tbody>
    </table>

    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Сохранить изменения'); ?>"></p>

  </form>
</div>
