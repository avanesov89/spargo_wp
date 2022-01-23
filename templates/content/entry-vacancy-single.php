<?php
/**
 * Шаблон отодражения страницы с вакансией
 */
$fields = [];
foreach (get_field_objects() as $key => $field) {
  $fields[$key] = [
    'label' => $field['label'],
    'data'  => $field['value'],
  ];
}
?>
<div class="row">
  <div class="wrapper__content text__block">
    <?php the_title('<h1>', '</h1>'); ?>

    <?php if (!empty($fields['wages']['data'])) : ?>
      <div class="vacancies__salary"><?php esc_html_e($fields['wages']['data']); ?></div>
    <?php endif; ?>

    <div class="vacancies__info">
      <?php if (!empty($fields['region']['data'])) : ?>
        <div class="vacancies__info-item"><?php esc_html_e($fields['region']['data']); ?></div>
      <?php endif; ?>
      <?php if (!empty($fields['experience']['data'])) : ?>
        <div class="vacancies__info-item">
          <?php _e('Требуемый опыт работы'); ?>: <?php esc_html_e($fields['experience']['data']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($fields['employment']['data'])) : ?>
        <div class="vacancies__info-item">
          <?php esc_html_e($fields['employment']['data']); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php
    the_content(
      sprintf(
        wp_kses(
        /* translators: %s: Name of current post. Only visible to screen readers */
          __('Читать далее<span class="screen-reader-text"> "%s"</span>'),
          [
            'span' => [
              'class' => [],
            ],
          ]
        ),
        get_the_title()
      )
    );

    wp_link_pages(['before' => '<div class="page-links">' . __('Страницы:'), 'after'  => '</div>']);
    ?>

    <?php if (!empty($fields['duties']['data'])) : ?>
      <p><strong><?php esc_html_e($fields['duties']['label']); ?>:</strong></p>
      <?php echo apply_filters('the_content', $fields['duties']['data']); ?>
    <?php endif; ?>

    <?php if (!empty($fields['suggestions']['data'])) : ?>
      <p><strong><?php esc_html_e($fields['suggestions']['label']); ?>:</strong></p>
      <?php echo apply_filters('the_content', $fields['suggestions']['data']); ?>
    <?php endif; ?>

    <?php if (!empty($fields['offer']['data'])) : ?>
      <p><strong><?php esc_html_e($fields['offer']['label']); ?>:</strong></p>
      <?php echo apply_filters('the_content', $fields['offer']['data']); ?>
    <?php endif; ?>

  </div>

  <div class="vacancies__bottom">
    <div class="vacancies__buttons">
      <button class="main__button btn-reset" data-hystmodal=".modal-vacancy">
        Откликнуться
      </button>

      <?php if (!empty($fields['hh_url']['data'])) : ?>
        <a href="<?php echo esc_url($fields['hh_url']['data']); ?>" class="main__button btn-reset">
          <?php _e('Вакансия на hh.ru'); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_template_part('templates/forms/vacancy', 'modal', ['form_id' => Theme_Posts_Vacancy::get_option('response_id')]); ?>