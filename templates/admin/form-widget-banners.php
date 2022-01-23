<?php
/**
 * Форма настройки виджета Баннеры
 * @var $args
 */
?>
<p class="widget-option">
  <label for="<?php esc_attr_e($args['title']['id']); ?>"><?php _e('Заголовок'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['title']['id']); ?>" name="<?php esc_attr_e($args['title']['name']); ?>" type="text" value="<?php esc_attr_e($args['title']['value']); ?>" />
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['description']['id']); ?>"><?php _e('Описание'); ?></label>
  <textarea class="widefat" id="<?php esc_attr_e($args['description']['id']); ?>" name="<?php esc_attr_e($args['description']['name']); ?>" rows="5"><?php esc_attr_e($args['description']['value']); ?></textarea>
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['slider']['id']); ?>"><?php _e('Слайдер'); ?></label>
  <select class="widefat" id="<?php esc_attr_e($args['slider']['id']); ?>" name="<?php esc_attr_e($args['slider']['name']); ?>">
    <?php foreach ($args['slider_choices'] as $id => $name) : ?>
      <option value="<?php esc_attr_e($id); ?>" <?php selected($args['slider']['value'], $id); ?>><?php esc_html_e($name); ?></option>
    <?php endforeach; ?>
  </select>
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['numberposts']['id']); ?>"><?php _e('Количество отображаемых баннеров'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['numberposts']['id']); ?>" name="<?php esc_attr_e($args['numberposts']['name']); ?>" type="text" value="<?php esc_attr_e($args['numberposts']['value']); ?>" />
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['layout']['id']); ?>"><?php _e('Форма отображения'); ?></label>
  <select class="widefat" id="<?php esc_attr_e($args['layout']['id']); ?>" name="<?php esc_attr_e($args['layout']['name']); ?>">
    <option value="cover" <?php selected($args['layout']['value'], 'cover'); ?>><?php _e('Обложка'); ?></option>
    <option value="table" <?php selected($args['layout']['value'], 'table'); ?>><?php _e('Таблица'); ?></option>
  </select>
</p>