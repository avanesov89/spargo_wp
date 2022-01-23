<?php
/**
 * Шаблон отображения блока социальных сетей в сайдбаре категории
 */
?>
<div class="news__sidebar-block">
  <div class="news__sidebar-title">
    <?php _e('Подписывайте на наши новости'); ?>
  </div>
  <ul class="header__social list-reset">
    <?php if (!empty($social_vk = theme_option('social_vk'))) : ?>
      <li class="header__social-item">
        <a href="<?php echo esc_url($social_vk); ?>" class="header__list-link" title="<?php _e('Спарго технологии в вконтакте'); ?>">
          <?php theme_svg('social_vk'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_facebook = theme_option('social_facebook'))) : ?>
      <li class="header__social-item">
        <a href="<?php echo esc_url($social_facebook); ?>" class="header__list-link" title="<?php _e('Спарго технологии в фейсбук'); ?>">
          <?php theme_svg('social_facebook'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_odn = theme_option('social_odn'))) : ?>
      <li class="header__social-item">
        <a href="<?php echo esc_url($social_odn); ?>" class="header__list-link" title="<?php _e('Спарго технологии в одноклассниках'); ?>">
          <?php theme_svg('social_odn'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_instagram = theme_option('social_instagram'))) : ?>
      <li class="header__social-item">
        <a href="<?php echo esc_url($social_instagram); ?>" class="header__list-link" title="<?php _e('Спарго технологии в инстаграме'); ?>">
          <?php theme_svg('social_instagram'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_telegram = theme_option('social_telegram'))) : ?>
      <li class="header__social-item">
        <a href="<?php echo esc_url($social_telegram); ?>" class="header__list-link" title="<?php _e('Спарго технологии в телеграм'); ?>">
          <?php theme_svg('social_telegram'); ?>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</div>

