<?php
/**
 * Action main Widget
 * @var $instance
 */
?>
<div class="main__action">
  <div class="container">
    <div class="main__action-content">
      <h3 class="main__action-title">
        <?php echo $instance['title']; ?>
      </h3>
      <p class="main__action-text">
        <?php echo $instance['description']; ?>
      </p>
    </div>
    <div class="main__action-button">
      <button class="main__button btn-reset" data-hystmodal=".modal-cooperation">
        <?php echo $instance['btn_label']; ?>
      </button>
    </div>
  </div>

  <?php get_template_part('templates/forms/action', 'modal', ['form_id' => $instance['form']]); ?>
</div>
