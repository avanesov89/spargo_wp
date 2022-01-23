<?php
/**
 * Фильтр вакансий по департаментам в консоли
 * @var $filter_department
 * @var $departments
 */
?>
<select name="vacancy_department" id="filter-by-vacancy-department">
  <option value="0" <?php selected($filter_department, 0, true); ?>><?php _e('Все департаменты'); ?></option>
  <?php foreach ($departments as $term) : ?>
    <option value="<?php echo $term->term_id; ?>" <?php selected($filter_department, $term->term_id, true); ?>>
      <?php esc_html_e($term->name); ?>
    </option>
  <?php endforeach; ?>
</select>