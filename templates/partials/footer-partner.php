<?php
$form_id = Theme_Posts_Partner::get_option('form_id');
if (absint($form_id) > 0) :
?>
<div class="footnote">
  <div class="footnote__content">
    <div class="footnote__title">
      <?php echo Theme_Posts_Partner::get_option('footer_title'); ?>
    </div>

    <?php echo apply_filters('the_content', Theme_Posts_Partner::get_option('footer_description'))?>
  </div>
  <div class="footnote__buttons">
    <button class="main__button btn-reset" data-hystmodal=".modal-partners">
      <?php echo Theme_Posts_Partner::get_option('footer_button'); ?>
    </button>
  </div>
</div>
<?php
get_template_part('templates/forms/partner', 'modal', ['form_id' => $form_id]);
endif;