<?php
/**
 * Форма настройки виджета Форма обратной связи
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
  <label for="<?php esc_attr_e($args['form']['id']); ?>"><?php _e('Форма обратной связи'); ?></label>
  <select class="widefat" id="<?php esc_attr_e($args['form']['id']); ?>" name="<?php esc_attr_e($args['form']['name']); ?>">
    <?php foreach ($args['forms_choices'] as $id => $name) : ?>
      <option value="<?php esc_attr_e($id); ?>" <?php selected($args['form']['value'], $id); ?>><?php esc_html_e($name); ?></option>
    <?php endforeach; ?>
  </select>
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['btn_label']['id']); ?>"><?php _e('Текст кнопки'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['btn_label']['id']); ?>"
         name="<?php esc_attr_e($args['btn_label']['name']); ?>"
         type="text"
         value="<?php esc_attr_e($args['btn_label']['value']); ?>" />
</p>
