<?php
/**
 * Форма настройки виджета "Отзывы"
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
  <label for="<?php esc_attr_e($args['numberposts']['id']); ?>"><?php _e('Количество отображаемых записей'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['numberposts']['id']); ?>" name="<?php esc_attr_e($args['numberposts']['name']); ?>" type="text" value="<?php esc_attr_e($args['numberposts']['value']); ?>" />
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['btn_label']['id']); ?>"><?php _e('Текст кнопки'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['btn_label']['id']); ?>"
         name="<?php esc_attr_e($args['btn_label']['name']); ?>"
         type="text"
         value="<?php esc_attr_e($args['btn_label']['value']); ?>" />
</p>