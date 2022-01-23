<?php
/**
 * Шаблон содержимого страницы с решением (single-app.php)
 */
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block app__content">
        <div class="text__page">
          <?php echo apply_filters('the_content', get_the_content()); ?>
        </div>
      </div>
    </div>
  </div>

  <?php if ($presentation = get_field('presentation')) : ?>
    <div class="app__presentation text__block">
      <?php echo $presentation; ?>
    </div>
  <?php endif; ?>

  <?php if ($modules = get_field('modules')) : ?>
    <div class="app__modules">
      <div class="container">
        <div class="row">
          <div class="app__modules-title">
            <?php echo (!empty($modules['modules_title'])) ? $modules['modules_title'] : __('Дополнительные модули'); ?>
          </div>

          <?php if (!empty($modules['modules_description'])) : ?>
            <div class="app__modules-text">
              <?php echo $modules['modules_description']; ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if (!empty($modules['modules_list'])) : ?>
          <div class="row">
            <div class="app__modules-list">
              <?php echo $modules['modules_list']; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($form_id = Theme_Posts_App::get_option('form_id')) :
    $form = get_post($form_id);
    ?>
    <div class="contacts__form app__form">
      <div class="container">
        <div class="contacts__form-title">
          <?php echo $form->post_title; ?>
        </div>
        <?php echo do_shortcode('[contact-form-7 id="' . $form->ID . '" html_class="main__form"]'); ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($docs = get_field('docs')) : ?>
    <div class="app__documentation">
      <div class="container">
        <?php if ($docs['files']) : ?>
          <div class="app__documentation-files">
            <div class="app__documentation-title">
              <?php _e('Документация'); ?>
            </div>
            <ul class="app__documentation-list list-reset">
              <?php foreach ($docs['files'] as $file) : ?>
                <li class="app__documentation-files">
                  <a href="<?php echo $file->guid; ?>" title="<?php esc_attr_e($file->post_title); ?>" class="app__documentation-link transition">
                    <?php theme_svg(str_replace(['application/', 'vnd.openxmlformats-officedocument.'], ['icon-', ''], $file->post_mime_type)); ?>
                    <?php echo $file->post_title; ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <?php if ($docs['table']) : ?>
          <div class="app__documentation-system">
            <div class="app__documentation-title">
              <?php _e('Системные требования'); ?>
            </div>

            <div class="app__documentation-table">
              <?php echo $docs['table']; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php get_template_part('templates/widgets/app', 'faq', ['section_class' => 'app__faq']); ?>
</div>
