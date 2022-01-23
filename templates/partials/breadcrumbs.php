<?php
/**
 * Шаблон хлебных крошек
 * @var $args
 */
?>
<div class="breadcrumbs">
  <div class="container">
    <?php if (!empty($args['title'])) : ?>
      <div class="breadcrumbs__title"><?php echo $args['title']; ?></div>
    <?php endif; ?>

    <ul class="breadcrumbs__list list-reset">
      <?php if(function_exists('bcn_display_list')) bcn_display_list(); ?>
    </ul>
  </div>
</div>