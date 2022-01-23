<?php
/**
 * Шаблон комментария
 * @var $args
 */
$comment = get_comment($args['comment_id']);

$comment_reply_link_args = [
  'reply_text' => __('Ответить'),
  'depth' => 1,
  'max_depth' => 2
];
?>
<div id="comment-<?php echo $comment->comment_ID; ?>" class="comments__element">
  <div class="comments__block <?php if (absint($comment->comment_parent) > 0) : ?>comments__block-level<?php endif; ?>">
    <div class="comments__block-info">
      <div class="comments__user">
        <div class="comments__user-avatar">
          <img src="<?php esc_attr_e(get_avatar_url($comment->user_id, ['scheme' => 'https'])); ?>" alt="<?php echo $comment->comment_author; ?>" class="comments__user-image">
        </div>
      </div>

      <div class="comments__detail">
        <div class="comments__detail-name">
          <?php echo $comment->comment_author; ?>
        </div>
        <div class="comments__detail-list">
          <?php if (current_user_can('manage_options')) :  ?>
            <div class="comments__detail-element">
              <a class="comments__detail-link" href="<?php echo wp_nonce_url(admin_url("comment.php?c=$comment->comment_ID&action=deletecomment" ), 'delete-comment_' . $comment->comment_ID); ?>">
                <?php theme_svg('icon__delete'); ?>
              </a>
            </div>

            <div class="comments__detail-element">
              <a class="comments__detail-link" href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>" target="_blank">
                <?php theme_svg('icon__edit'); ?>
              </a>
            </div>
          <?php endif; ?>
          <div class="comments__detail-element comments__detail-element--counter">
            #<?php echo $args['num']; ?>
          </div>
          <time class="comments__detail-element comments__detail-element--date">
            <?php echo get_comment_date('d.m.Y', $comment->comment_ID); ?>
          </time>
        </div>
      </div>
      <?php if (absint($comment->comment_parent) == 0) : ?>
        <div class="comments__block-answer">
          <?php comment_reply_link($comment_reply_link_args, $comment); ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="comments__block-content">
      <?php echo apply_filters('comment_text', $comment->comment_content); ?>
    </div>
  </div>
</div>