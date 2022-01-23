<?php
/**
 * Архив записей автора
 * @var $author_name
 * @var $author
 */
get_header();

do_action('breadcrumbs', ['title' => __('Результат поиска') . ' - ' . get_the_archive_title()]);

$current_author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

$custom_avatar = get_field('avatar', 'user_' . $current_author->ID);
$avatar = ($custom_avatar) ? $custom_avatar : get_avatar_url($current_author->ID);
?>
<div class="wrapper">
  <div class="container">
    <div class="row">
      <div class="wrapper__content text__block">
        <div class="blog__info-text">
          <?php _e('Все материалы автора:'); ?>
          <div class="blog__info-author">
            <div class="blog__info-img">
              <img src="<?php echo $avatar; ?>" alt="<?php echo get_the_author_meta('display_name', $current_author->ID); ?>" class="blog__info-image">
            </div>
            <div class="blog__info-name">
              <?php echo get_the_author_meta('display_name', $current_author->ID); ?>
              <?php if ($author_post = get_field('post', 'user_' . $current_author->ID)) : ?>
                <div class="blog__info-status">
                  <?php echo $author_post; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="blog__items">
          <?php
          // Start the Loop.
          while (have_posts()) :
            the_post();

            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part('templates/content/entry-search', 'result');

            // End the loop.
          endwhile;
          ?>
        </div>

      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <?php
      $pagination = paginate_links([
        'type'      => 'array',
        'prev_text' => __('Ранее'),
        'next_text' => __('Далее'),
      ]);
      get_template_part('templates/partials/pagination', null, $pagination);
      ?>
    </div>
  </div>
</div>
<?php
get_footer();

