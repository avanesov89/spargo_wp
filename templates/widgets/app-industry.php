<?php
$slider_id = Theme_Posts_App::get_option('industry_slider');
if (empty($slider_id)) {
  exit();
}
$slider = get_term($slider_id);
$banners = new WP_Query([
  'post_type'         => 'banner',
  'nopaging'          => true,
  'orderby'           => 'menu_item',
  'order'             =>  'ASC',
  'posts_per_page'    => -1,
  'tax_query'         => [
    'relation'        => 'AND',
    [
      'taxonomy'      => 'slider',
      'field'         => 'term_id',
      'terms'         => $slider_id,
    ],
  ],
]);
$slider_options = [
  'slidesToShow'    => 4,
  'focusOnSelect'   => true,
  'dots'            => true,
  'appendDots'      => '#app-industry-slider-dots',
  'dotsClass'       => 'list-reset section__slaider-dots',
  'arrows'          => false,
  'infinite'        => true,
  'slidesToScroll'  => 1,
  'responsive'  => [
    [
      'breakpoint'  => 1320,
      'settings'  => [
        'slidesToShow'    => 4,
        'focusOnSelect'   => true,
        'dots'            => true,
        'appendDots'      => '#app-industry-slider-dots',
        'dotsClass'       => 'list-reset section__slaider-dots',
        'arrows'          => false,
        'slidesToScroll'  => 1,
      ]
    ],
    [
      'breakpoint'  => 1024,
      'settings'  => [
        'slidesToShow'    => 3,
        'focusOnSelect'   => true,
        'dots'            => true,
        'appendDots'      => '#app-industry-slider-dots',
        'dotsClass'       => 'list-reset section__slaider-dots',
        'arrows'          => false,
        'slidesToScroll'  => 1,
      ]
    ],
    [
      'breakpoint'  => 1023,
      'settings' => 'unslick'
    ],
  ],
];
?>
<div class="industry__block">
  <div class="container">
    <div class="row">
      <div class="industry__block-top">
        <div class="industry__block-title">
          <?php echo $slider->name; ?>
        </div>

        <?php if (!empty($slider->description)) : ?>
        <div class="industry__block-span">
          <?php echo $slider->description;?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($banners) : ?>
      <div class="row">
        <div id="app-industry-slider" class="industry__list" data-slick data-slick-options='<?php echo json_encode($slider_options); ?>'>
          <?php
          while ($banners->have_posts()) :
            $banners->the_post();
            ?>
            <div>
              <div class="industry__list-item">
                <?php the_title('<div class="industry__list-title">', '</div>'); ?>
                <div class="industry__list-text">
                  <?php echo get_the_content(); ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <div id="app-industry-slider-dots" class="section__slaider"></div>
      </div>
    <?php endif; ?>
  </div>
</div>
