/* global jQuery */
+(function ($) {
  $.init = {
    doc: $(document),

    // Скрипт-ловушка слайдеров
    slick: function ($container) {
      var $selector = ('undefined' != typeof $container) ? $container.find('[data-slick]') : $('[data-slick]');

      if (0 < $selector.length) {
        $.each($selector, function () {
          var $this = $(this);
          var options = $this.data('slick-options');

          if ('undefined' != typeof options) {
            $this.slick(options);
          }
        });
      }
    },

    vacancy_form_load: function() {
      this.doc.on('change', '.wpcf7-form input[type="file"]', function (event) {
        //event.preventDefault();
        const $input = $(event.currentTarget);
        const filename = $input.val().replace(/C:\\fakepath\\/i, '');
        const inputName = $input.attr('name');
        const $label = $input.closest('form').find('label[for="'+inputName+'"]');
        if (filename.length > 0) {
          $label.find('.field-file__label--text').text(filename);
        }
      });


    }
  }
}(jQuery));

/* Запуск скриптов для фронтенда */
+(function ($) {
  'use strict';

  // Инициализация сторонних скрипотв
  $.init.slick();

  $.init.vacancy_form_load();

}(jQuery));