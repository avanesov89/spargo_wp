<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block news__element">
        <div class="news__element-detail">
          <div class="news__element-item news__element-date">
            <?php echo get_the_date('d.m.Y'); ?>
          </div>
          <div class="news__element-item">
            <?php echo do_shortcode('[post-views]'); ?>
          </div>
        </div>

        <?php the_title('<h1>', '</h1>'); ?>

        <?php if (has_post_thumbnail()) : ?>
        <div class="news__element-img">
          <?php the_post_thumbnail('original', ['class' => 'news__element-image', 'alt' => esc_attr(get_the_title())]); ?>
        </div>
        <?php endif; ?>

        <?php
        the_content(
          sprintf(
            wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
              __('Читать далее<span class="screen-reader-text"> "%s"</span>'),
              [
                'span' => [
                  'class' => [],
                ],
              ]
            ),
            get_the_title()
          )
        );

        wp_link_pages(
          [
            'before' => '<div class="page-links">' . __('Страницы:'),
            'after'  => '</div>',
          ]
        );

        if (has_tag()) :
          ?>
          <div class="news__element-bottom">
            <div class="tags">
              <span><?php _e('Теги'); ?></span>
              <?php
              $tags = get_the_tags();
              foreach ($tags as $tag):
                ?>
                <a href="<?php echo get_tag_link($tag->term_id); ?>" title="<?php esc_attr_e($tag->name); ?>>" class="tags__item transition">
                  <?php echo $tag->name; ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
