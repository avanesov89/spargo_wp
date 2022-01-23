<div class="footer__block">
  <ul class="footer__phones list-reset">
    <?php if (!empty($corp_phone_mobile = theme_option('corp_phone_mobile'))) : ?>
      <li class="footer__phones-item">
        <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $corp_phone_mobile); ?>" class="footer__phones-link">
          <?php esc_html_e($corp_phone_mobile); ?>
        </a>
        <span class="footer__phones-tooltip">- <?php _e('бесплатный по РФ'); ?></span>
      </li>
    <?php
    endif;
    if (!empty($corp_phone_city = theme_option('corp_phone_city'))) :
    ?>
      <li class="footer__phones-item">
        <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $corp_phone_city); ?>" class="footer__phones-link">
          <?php esc_html_e($corp_phone_city); ?>
        </a>
        <span class="footer__phones-tooltip footer__phones-callback" data-hystmodal=".modal-callback">- <?php _e('заказать звонок'); ?></span>
      </li>
    <?php endif; ?>
  </ul>

  <ul class="footer__mails list-reset">
    <?php if (!empty($corp_email_default = theme_option('corp_email_default'))) : ?>
    <li class="footer__mails-item">
      <a href="mailto:<?php echo $corp_email_default; ?>" class="footer__mails-link"><?php echo $corp_email_default; ?></a>
    </li>
    <?php endif; ?>
    <?php if (!empty($corp_email_support = theme_option('corp_email_support'))) : ?>
    <li class="footer__mails-item">
      <a href="mailto:+<?php echo $corp_email_support; ?>" class="footer__mails-link"><?php echo $corp_email_support; ?></a>
    </li>
    <?php endif; ?>
  </ul>

  <?php if (!empty($corp_address = theme_option('corp_address'))) : ?>
    <div class="footer__address">
      <?php echo $corp_address; ?>
      <?php if ($page_contacts_id = theme_option('contacts_page')) : ?>
      <a href="<?php echo get_permalink($page_contacts_id); ?>" class="footer__address-tooltip">(<?php _e('схема проезда'); ?>)</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <ul class="footer__social list-reset">
    <?php if (!empty($social_vk = theme_option('social_vk'))) : ?>
      <li class="footer__social-item">
        <a href="<?php echo esc_url($social_vk); ?>" class="footer__social-link" title="<?php _e('Спарго технологии в вконтакте'); ?>">
          <?php theme_svg('social_vk'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_facebook = theme_option('social_facebook'))) : ?>
      <li class="footer__social-item">
        <a href="<?php echo esc_url($social_facebook); ?>" class="footer__social-link" title="<?php _e('Спарго технологии в фейсбук'); ?>">
          <?php theme_svg('social_facebook'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_odn = theme_option('social_odn'))) : ?>
      <li class="footer__social-item">
        <a href="<?php echo esc_url($social_odn); ?>" class="footer__social-link" title="<?php _e('Спарго технологии в одноклассниках'); ?>">
          <?php theme_svg('social_odn'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_instagram = theme_option('social_instagram'))) : ?>
      <li class="footer__social-item">
        <a href="<?php echo esc_url($social_instagram); ?>" class="footer__social-link" title="<?php _e('Спарго технологии в инстаграме'); ?>">
          <?php theme_svg('social_instagram'); ?>
        </a>
      </li>
    <?php endif; ?>

    <?php if (!empty($social_telegram = theme_option('social_telegram'))) : ?>
      <li class="footer__social-item">
        <a href="<?php echo esc_url($social_telegram); ?>" class="footer__social-link" title="<?php _e('Спарго технологии в телеграм'); ?>">
          <?php theme_svg('social_telegram'); ?>
        </a>
      </li>
    <?php endif; ?>
  </ul>

  <div class="footer__company">
    <img src="<?php echo THEME_ASSETS ?>img/protek__logo.png" alt="#" class="footer__company-img">
  </div>


</div>
