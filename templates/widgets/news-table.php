<?php
/**
 * News layout "Table"
 * @var $posts
 * @var $instance
 */
if ($posts) : ?>
  <div class="last__renewal">
    <div class="container">
      <div class="row">
        <div class="main__title">
          <?php echo $instance['title']; ?>
          <div class="main__title-span">
            <?php echo $instance['description']; ?>
          </div>
        </div>
      </div>

      <?php do_action('news_start', ['layout' => 'table']); ?>

      <div class="row">
        <div class="last__renewal-list">
          <?php
          while ($posts->have_posts()) :
            $posts->the_post();

            get_template_part('templates/content/entry-news', 'table');
          endwhile;
          ?>
        </div>
      </div>

      <?php do_action('news_end', ['layout' => 'table', 'term_id' => $instance['term'], 'label' => $instance['more_label']]); ?>

    </div>
  </div>
<?php
endif;
