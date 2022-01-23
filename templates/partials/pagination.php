<?php
/**
 * Шаблон пагинации в категориях новостей
 * @var $args
 */
if (!empty($args)):
?>
  <ul class="pagination list-reset">
    <?php foreach ($args as $item) : ?>
      <li class="pagination__item">
        <?php echo str_replace(['page-numbers', 'current'], ['pagination__link transition', 'pagination__link-active'], $item); ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php
endif;
