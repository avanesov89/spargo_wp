<?php
/**
 * Блок с цитатой на странице "О компании"
 * @var $args
 */
$message = get_field('message', $args['post_id']);
$photo = get_field('photo', $args['post_id']);
$name = get_field('name');
$position = get_field('position');
if ($message) :
?>
  <div class="about__director">
    <div class="about__director-block">
      <div class="about__director-photo">
        <?php if ($photo) : ?>
          <div class="about__director-img">
            <?php echo wp_get_attachment_image($photo, 'original', false, ['class' => 'about__director-image', 'alt' => ($name) ? $name : '']); ?>
          </div>
        <?php endif; ?>
        <div class="about__director-name about__director-name--mobail">
          <?php if ($name) : echo $name; endif; ?>
          <?php if ($position) : ?>
          <div class="about__director-status">
            <?php echo $position; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="about__director-content">
        <div class="about__director-name">
          <?php if ($name) : echo $name; endif; ?>
          <?php if ($position) : ?>
            <div class="about__director-status">
              <?php echo $position; ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="about__director-quote">
          <?php echo apply_filters('the_content', $message); ?>
        </div>
      </div>
    </div>
  </div>
<?php
endif;
