<?php
/**
 * News layout "Table" footer
 * @var $args
 */
?>
<div class="row">
  <a href="<?php echo ($args['term']) ? get_term_link($args['term']) : get_permalink(get_option('page_for_posts')); ?>" title="<?php esc_attr_e($args['label']); ?>>" class="main__button btn-reset">
    <?php echo $args['label']; ?>
  </a>
</div>
