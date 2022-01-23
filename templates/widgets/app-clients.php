<?php
$slider_id = Theme_Posts_App::get_option('clients_slider');
if (empty($slider_id)) {
  exit();
}
$slider = get_term($slider_id);
$banners = Theme_Posts_Banners::get_slider_banners($slider_id);
$slider_options = [
  'slidesToShow'    => 8,
  'focusOnSelect'   => true,
  'dots'            => true,
  'appendDots'      => '#app-clients-slider-dots',
  'dotsClass'       => 'list-reset section__slaider-dots',
  'arrows'          => false,
  'infinite'        => true,
  'slidesToScroll'  => 2,
  'responsive'  => [
    [
      'breakpoint'  => 1023,
      'settings' => 'unslick'
    ]
  ]
];
?>
<div class="clients__block">
  <div class="container">
    <div class="row">
      <div class="clients__block-top">
        <div class="clients__block-title">
          <?php echo $slider->name; ?>
        </div>
        <?php if (!empty($slider->description)) : ?>
          <div class="clients__block-span">
            <?php echo $slider->description;?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="row">
      <?php if ($banners) : ?>
        <div id="app-clients-slider" class="clients__list" data-slick data-slick-options='<?php echo json_encode($slider_options); ?>'>
          <?php
          while ($banners->have_posts()) :
            $banners->the_post();
            ?>
            <div>
              <div class="clients__list-item">
                <?php the_post_thumbnail('big', ['class' => 'clients__list-image', 'alt' => get_the_title()]); ?>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <div id="app-clients-slider-dots" class="section__slaider"></div>
      <?php endif; ?>
    </div>
  </div>
</div>