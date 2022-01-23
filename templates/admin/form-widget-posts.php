<?php
/**
 * Форма настройки виджета Новости
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
  <label for="<?php esc_attr_e($args['term']['id']); ?>"><?php _e('Рубрика'); ?></label>
  <select class="widefat" id="<?php esc_attr_e($args['term']['id']); ?>" name="<?php esc_attr_e($args['term']['name']); ?>">
    <?php foreach ($args['terms_choices'] as $id => $name) : ?>
      <option value="<?php esc_attr_e($id); ?>" <?php selected($args['term']['value'], $id); ?>><?php esc_html_e($name); ?></option>
    <?php endforeach; ?>
  </select>
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['more_label']['id']); ?>"><?php _e('Текст для ссылки на рубрику'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['more_label']['id']); ?>"
         name="<?php esc_attr_e($args['more_label']['name']); ?>"
         type="text"
         value="<?php esc_attr_e($args['more_label']['value']); ?>" />
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['numberposts']['id']); ?>"><?php _e('Количество отображаемых записей'); ?></label>
  <input class="widefat" id="<?php esc_attr_e($args['numberposts']['id']); ?>" name="<?php esc_attr_e($args['numberposts']['name']); ?>" type="text" value="<?php esc_attr_e($args['numberposts']['value']); ?>" />
</p>

<p class="widget-option">
  <label for="<?php esc_attr_e($args['layout']['id']); ?>"><?php _e('Форма отображения'); ?></label>
  <select class="widefat" id="<?php esc_attr_e($args['layout']['id']); ?>" name="<?php esc_attr_e($args['layout']['name']); ?>">
    <option value="table" <?php selected($args['layout']['value'], 'table'); ?>><?php _e('Таблица'); ?></option>
    <option value="cards" <?php selected($args['layout']['value'], 'cards'); ?>><?php _e('Карточки'); ?></option>
  </select>
</p>