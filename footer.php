  <div class="main__indent">

  </div>

  <footer class="footer">
    <div class="container">
      <?php get_template_part('templates/base/footer', 'contacts'); ?>

      <?php get_template_part('templates/base/footer', 'nav', ['menu' => 'footer_left']); ?>

      <?php get_template_part('templates/base/footer', 'nav', ['menu' => 'footer_right']); ?>

      <?php get_template_part('templates/base/footer', 'subscription', ['cf7_form' => '84']); ?>
    </div>

    <?php get_template_part('templates/base/footer', 'bottom'); ?>
  </footer>

  <div class="body-overlay"></div>

  <?php get_template_part('templates/partials/mobile', 'menu'); ?>

  <?php get_template_part('templates/forms/callback', 'modal'); ?>
</div><!-- /.site-container -->

<?php if (!empty($cookies_text = theme_option('cookies_text'))) : ?>
  <div class="cookies"><?php echo $cookies_text; ?>></div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>

</html>