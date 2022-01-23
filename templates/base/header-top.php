<div class="header__top">
  <div class="container">
    <ul class="header__list list-reset">
      <?php if (!empty($corp_email_default = theme_option('corp_email_default'))) : ?>
        <li class="header__list-item">
          <a href="mailto:<?php esc_html_e($corp_email_default); ?>" class="header__list-link" title="<?php _e('Элекронный адрес Спарго технологии'); ?>">
            <?php
            theme_svg('mail_icon');
            esc_html_e($corp_email_default);
            ?>
          </a>
        </li>
      <?php endif; ?>

      <?php if (!empty($corp_phone_mobile = theme_option('corp_phone_mobile'))) : ?>
        <li class="header__list-item">
          <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $corp_phone_mobile); ?>" class="header__list-link" title="Номер телефона Спарго технологии">
            <?php theme_svg('phone_icon');
            esc_html_e($corp_phone_mobile); ?>
          </a>
          <span class="header__list-modal" data-hystmodal=".modal-callback">(<?php _e('обратный звонок'); ?>)</span>
        </li>
      <?php endif; ?>
    </ul>


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
</div>