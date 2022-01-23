<?php
/**
 * @var $args
 */
$slider_id = Theme_Posts_App::get_option('faq_slider');
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
if ($banners) : ?>
  <div class="faq__section <?php if (!empty($args['section_class'])) echo $args['section_class']; ?>">
    <div class="container">
      <div class="row">
        <div class="faq__section-title">
          <?php echo $slider->name; ?>
        </div>
      </div>

      <div class="row">
        <div class="faq__section-list">
          <?php
          while ($banners->have_posts()) :
            $banners->the_post();
            ?>
            <div <?php post_class('faq__section-item'); ?>>
              <details>
                <summary>
                  <?php the_title('<div class="faq__section-question">', '</div>'); ?>
                </summary>
                <div class="faq__section-answer">
                  <?php the_content(false); ?>
                </div>
              </details>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
<?php
endif;

