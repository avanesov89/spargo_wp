<div class="search__fixed">
  <div class="container">
    <form role="search" method="get" id="searchform" class="search__fixed-form" action="<?php echo home_url('/') ?>">
      <div class="search__fixed-field">
        <input type="search" class="search__fixed-input" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Введите ключевой запрос">
        <button class="search__fixed-button main__button btn-reset" type="submit" value="<?php _e('Найти'); ?>"><?php _e('Найти'); ?></button>
      </div>
    </form>
  </div>
</div>