<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

do_action('breadcrumbs', ['title' => (get_field('title_alt')) ? get_field('title_alt') : get_the_title()]);

$notice = get_field('notice');

$show_notice = ('on' == get_field('notice_show'));

if ($notice && $show_notice) {
  $current_day = absint(date('d'));
  $notice_days = get_field_object('notice_days');
  $notice_period = $notice_days['value'];

  if (!empty($notice_period)) {
    $show_notice = false;

    if ($current_day >= absint($notice_period['from']) && $current_day <= absint($notice_period['to'])) {
      $show_notice = true;
    }
  }
}
?>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="wrapper__content text__block">
          <?php the_title('<h1>', '</h1>'); ?>

          <?php if ($show_notice): ?>
            <div class="holiday__time">
              <?php echo apply_filters('the_content', $notice); ?>
            </div>
          <?php endif; ?>

          <div class="hotline__contacts">
            <?php if ($schedule = get_field('schedule')) : ?>
              <div class="hotline__contacts-item hotline__contacts-item--time">
                <div class="hotline__contacts-title">
                  <?php _e('Режим работы службы поддержки'); ?>
                </div>
                <?php
                $schedule_items = explode(PHP_EOL, $schedule);
                foreach ($schedule_items as $schedule_item) :
                ?>
                  <span class="hotline__contacts-info"><?php echo $schedule_item; ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if ($email = get_field('email')) : ?>
              <div class="hotline__contacts-item hotline__contacts-item--mail">
                <div class="hotline__contacts-title">
                  <?php _e('E-mail адрес'); ?>:
                </div>
                <a href="mailto:<?php echo $email; ?>" class="hotline__contacts-info hotline__contacts-info--link">
                  <?php echo $email; ?>
                </a>
              </div>
            <?php endif; ?>

            <?php if (!empty($telegram_bot = get_field('telegram_bot'))) : ?>
              <div class="hotline__contacts-item hotline__contacts-item--telegram">
                <div class="hotline__contacts-title">
                  <?php _e('Telegram bot'); ?>
                </div>
                <a href="<?php echo $telegram_bot['url']; ?>" class="hotline__contacts-info hotline__contacts-info--link">
                  <?php echo $telegram_bot['name']; ?>
                </a>
              </div>
            <?php endif; ?>

            <?php if ($phone = get_field('phone')) : ?>
              <div class="hotline__contacts-item hotline__contacts-item--phone">
                <div class="hotline__contacts-title">
                  <?php _e('Телефон технической поддержки'); ?>
                </div>
                <?php
                $phone_items = explode(PHP_EOL, $phone);
                foreach ($phone_items as $phone_item) :
                  ?>
                  <a href="tel:<?php echo preg_replace('/[^0-9\+]/', '', $phone_item); ?>" class="hotline__contacts-info hotline__contacts-info--link">
                    &nbsp; <?php echo $phone_item; ?>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>

          <?php echo apply_filters('the_content', get_the_content()); ?>
        </div>
      </div>
    </div>

    <?php if (!empty($form = get_field('form'))) : ?>
      <div class="hotline__form">
        <div class="container">
          <div class="hotline__form-title">
            <?php echo $form['title']; ?>
          </div>

          <?php echo do_shortcode('[contact-form-7 id="' . $form['id'] . '" html_class="main__form"]'); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php
get_footer();