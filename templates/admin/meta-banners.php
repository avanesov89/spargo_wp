<div class="components-base-control">
  <div class="components-base-control__field">
    <label class="components-base-control__label" for="banner-extra-url"><?php _e('URL-адрес'); ?></label>
    <input class="components-text-control__input" name="extra[url]" type="text" id="banner-extra-url" value="<?php echo $meta['url']; ?>" />
  </div>
</div>

<?php if (trim($meta['url']) !== "") : ?>
  <p class="edit-post-post-link__preview-label"><?php _e('Просмотреть'); ?></p>
  <a target="_blank" class="components-external-link edit-post-post-link__link" href="<?php echo home_url($meta['url']); ?>">
    <span class="edit-post-post-link__link-prefix"><?php echo home_url(); ?>/</span>
    <span class="edit-post-post-link__link-post-name"><?php echo $meta['url']; ?></span>
    <span class="screen-reader-text"><?php _e('(откроется в новой вкладке)'); ?></span>
  </a>
<?php endif; ?>

<div class="components-base-control" style="margin-top: 10px;">
  <div class="components-base-control__field">
    <input id="banner-extra-blank" class="components-checkbox-control__input" type="checkbox" name="extra[blank]" value="1" <?php if (absint($meta['blank']) == 1) : ?>checked<?php endif; ?> />
    <label class="components-checkbox-control__label" for="banner-extra-blank"><?php _e('Открывать в новом окне'); ?></label>
  </div>
</div>

<div class="components-base-control">
  <div class="components-base-control__field">
    <label class="components-base-control__label" for="banner-extra-video"><?php _e('Ссылка на видео'); ?></label>
    <input class="components-text-control__input" name="extra[video]" type="text" id="banner-extra-video" value="<?php echo $meta['video']; ?>" />
  </div>
</div><?php
