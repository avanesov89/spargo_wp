<?php
/**
 * News layout "Cards"
 * @var $posts
 * @var $instance
 */
if ($posts) : ?>
  <div class="news__main">
    <div class="container">
      <div class="row">
        <div class="main__title">
          <?php echo $instance['title']; ?>
          <div class="main__title-span"><?php echo $instance['description']; ?></div>
        </div>
      </div>

      <div class="row">
        <div class="news__items">
          <?php
          while ($posts->have_posts()) :
            $posts->the_post();

            get_template_part('templates/content/entry-news', 'card');
          endwhile;
          ?>
        </div>
      </div>

      <?php do_action('news_end', ['layout' => 'cards', 'term_id' => $instance['term'], 'label' => $instance['more_label']]); ?>
    </div>
  </div>
<?php
endif;