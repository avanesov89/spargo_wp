<?php
/**
 * Banners layout "Cover"
 * @var $banners
 * @var $instance
 * @var $args
 */
$slider_options = [
  'slidesToShow'    => 6,
  'focusOnSelect'   => true,
  'dots'            => true,
  'appendDots'      => '#slick_dots_'. $args['widget_id'],
  'dotsClass'       => 'slaider__list list-reset',
  'arrows'          => false,
  'slidesToScroll'  => 2,
  'responsive'  => [
    [
      'breakpoint'  => 1920,
      'settings'  => [
        'slidesToShow'    => 8,
        'focusOnSelect'   => true,
        'dots'            => true,
        'appendDots'      => '#slick_dots_'. $args['widget_id'],
        'dotsClass'       => 'slaider__list list-reset',
        'arrows'          => false,
        'slidesToScroll'  => 2,
      ]
    ],
    [
      'breakpoint'  => 1320,
      'settings'  => [
        'slidesToShow'    => 6,
        'focusOnSelect'   => true,
        'dots'            => true,
        'appendDots'      => '#slick_dots_'. $args['widget_id'],
        'dotsClass'       => 'slaider__list list-reset',
        'arrows'          => false,
        'slidesToScroll'  => 2,
      ]
    ],
    [
      'breakpoint'  => 1024,
      'settings'  => [
        'slidesToShow'    => 5,
        'focusOnSelect'   => true,
        'dots'            => true,
        'appendDots'      => '#slick_dots_'. $args['widget_id'],
        'dotsClass'       => 'slaider__list list-reset',
        'arrows'          => false,
        'slidesToScroll'  => 2,
      ]
    ],
    [
      'breakpoint'  => 1023,
      'settings' => 'unslick'
    ],
  ]
];

if ($banners) : ?>
  <div class="retail__all">
    <div class="container">
      <div class="row">
        <div class="main__title">
          <?php echo $instance['title']; ?>
          <div class="main__title-span">
            <?php echo $instance['description']; ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div id="slick_<?php echo $args['widget_id'];?>" class="retail__all-list" data-slick data-slick-options='<?php echo json_encode($slider_options); ?>'>
          <?php
          while ($banners->have_posts()) :
            $banners->the_post();

            get_template_part('templates/content/entry-banner', 'retail');
          endwhile;
          ?>
        </div>
        <div id="slick_dots_<?php echo $args['widget_id'];?>" class="retail__all-dots"></div>
      </div>
    </div>
  </div>
<?php
endif;
