<?php
/**
 * Шаблон элемента записи в техническом блоге
 */
?>
<article <?php post_class('blog__item'); ?>>
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="blog__item-img">
      <?php the_post_thumbnail('original', ['class' => 'blog__item-image', 'alt' => esc_attr(get_the_title())]); ?>
    </div>
  <?php endif; ?>
  <div class="blog__item-content">
    <?php the_title('<h3 class="blog__item-title"><a href="'. get_the_permalink() . '" title="'. get_the_title() .'" class="blog__item-title--link transition">', '</a></h3>'); ?>

    <div class="blog__item-text">
      <?php
      if ( has_excerpt() ) :
        the_excerpt();
      else :
        esc_html(get_the_content(false));
      endif;
      ?>
    </div>
    <div class="blog__item-bottom">
      <div class="news__element-detail">
        <time class="news__element-item news__element-date" datetime="<?php echo get_the_date('d.m.Y'); ?>">
          <?php echo get_the_date('d.m.Y'); ?>
        </time>
        <div class="news__element-item">
          <?php echo do_shortcode('[post-views]'); ?>
        </div>
      </div>
      <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( get_the_title() ); ?>" class="blog__item-link transition">
        <?php _e('Читать дальше'); ?>
        <?php theme_svg('arrow__right'); ?>
      </a>
    </div>
  </div>
</article>
