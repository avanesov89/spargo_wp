<?php
/**
 * Шаблон отображения поста технического блога
 * @var $args
 */
$custom_avatar = get_field('avatar', 'user_' . get_the_author_meta('ID'));
$avatar = ($custom_avatar) ? $custom_avatar : get_avatar_url(get_the_author_meta('ID'));
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block news__element">
        <div class="news__element-detail">
          <div class="news__element-date news__element-item">
            <?php echo get_the_date('d.m.Y'); ?>
          </div>
          <div class="news__element-item news__element-views">
            <?php echo do_shortcode('[post-views]'); ?>
          </div>
          <div class="news__element-item">
            <?php _e('автор'); ?>: <?php echo get_the_author(); ?>
          </div>
          <div class="news__element-item">
            <?php _e('комментариев'); ?>: <span><?php echo get_comments_number(); ?></span>
          </div>
        </div>

        <?php the_title('<h1>', '</h1>'); ?>

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
        ?>

        <div class="news__element-bottom blog__info">
          <div class="blog__info-text">
            <?php _e('Автор'); ?>:
            <div class="blog__info-author">
              <div class="blog__info-img">
                <img src="<?php echo $avatar; ?>" alt="<?php echo get_the_author(); ?>" class="blog__info-image">
              </div>
              <div class="blog__info-name">
                <?php the_author_posts_link(); ?>
                <?php if ($author_post = get_field('post', 'user_' . get_the_author_meta('ID'))) : ?>
                <div class="blog__info-status">
                  <?php echo $author_post; ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <?php
          $tags = get_the_terms(get_the_ID(), 'dev_tag');
          if (!empty($tags)) : ?>
            <div class="blog__info-text">
              <?php _e('Технологии'); ?>:
              <div class="tags">
                <?php foreach ($tags as $tag) : ?>
                  <a href="<?php echo get_term_link($tag->term_id); ?>" title="<?php esc_attr_e($tag->name); ?>" class="tags__item transition">
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
  <?php if ( comments_open() || get_comments_number() ) {
    comments_template();
  }?>
</div>
