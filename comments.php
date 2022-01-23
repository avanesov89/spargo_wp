<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage spargo
 * @since 0.0.3
 */
if (post_password_required()) {
  return;
}
?>
<div id="comments" class="comments-area default-max-width <?php echo get_option('show_avatars') ? 'show-avatars' : ''; ?>">
  <div class="container">
    <div class="row">
      <div class="comments__section">
        <div class="comments__section-title">
          <?php printf('Комментариев: %d', get_comments_number()); ?>
        </div>

        <!-- Comments list -->
        <?php
        $comments_query_args = [
          'post_id'       => get_the_ID(),
          'status'        => 'approve',
          'hierarchical'  => true,
          'parent'    => 0
        ];

        $comments_query = new WP_Comment_Query( $comments_query_args );
        $comments = $comments_query->get_comments();

        if ( $comments ) {
          $num = 0;
          foreach ( $comments as $comment ) :
            $num++;
            if ($comment->comment_parent == 0) {
              get_template_part('templates/content/comment', 'item', ['num' => $num, 'comment_id' => $comment->comment_ID]);
            }
            if (!empty($comment_children = $comment->get_children())) {
              foreach ($comment_children as $child) {
                $num++;
                get_template_part('templates/content/comment', 'item', ['num' => $num, 'comment_id' => $child->comment_ID]);
              }
            }
          endforeach;
        } else {
          _e('Запись еще никто не комментировал');
        }
        ?>

        <!-- Comment pagination -->
        <?php the_comments_pagination(); ?>

        <!-- Comments form -->
        <?php comment_form(); ?>

      </div>
    </div>
  </div>
</div>
