<?php

/**
 * Опция для фильтра баннеров по принадлежности к слайдеру
 * @var $filter_slider
 * @var $sliders
 */
?>
<select name="banner_slider" id="filter-by-banner-slider">
  <option value="0" <?php selected($filter_slider, 0, true); ?>><?php _e('Все слайдеры'); ?></option>
  <?php foreach ($sliders as $item) : ?>
    <option value="<?php echo $item->term_id; ?>" <?php selected($filter_slider, $item->term_id, true); ?>>
      <?php esc_html_e($item->name); ?>
    </option>
  <?php endforeach; ?>
</select>
