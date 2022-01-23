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
console.log('maxgraph');

/**
 * название функции
 *
 * @param {number} first - первое число
 * @returns {number}
 */



$(function() {
  var btn = $(".header__search"), block = $(".search__fixed");
  $(document).click(function(event) {
    var target = $(event.target),cur;
    if (target.is(".header__search")) {
      event.preventDefault();
      var index = btn.index(target);
      cur = block.eq(index).fadeToggle();
      target.toggleClass("open")
    }
    if (target.closest(".search__fixed").length) return;
    block.not(cur).fadeOut("slow");
    btn.not(target).removeClass("open")
  })
});

// Accordeon
const details = Array.from(document.querySelectorAll("details"));
// Add the onclick listeners.
details.forEach((targetDetail) => {
  targetDetail.addEventListener("click", () => {
    // Close all the details that are not targetDetail.
    details.forEach((detail) => {
      if (detail !== targetDetail) {
        detail.removeAttribute("open");
      }
    });
  });
});



// MENU OPEN
//Открыть меню по клику на триггер
$('.menu-trigger').on('click', function(event){
  event.preventDefault();
  toggleMenu(true);
});
//Закрыть меню
$('.close-trigger, .body-overlay').on('click', function(event){
  event.preventDefault();
  toggleMenu(false);
});
//Добавить или убрать класс
function toggleMenu(bool) {
  $('body, .body-overlay, .a-menu').toggleClass('menu-open', bool);
};

// SUBMENU
$('.menu__item-drop').on('click', function(){
  if( $('.menu__item-drop').hasClass('open') ) {
    $('.menu__item-drop, .sub-menu').removeClass('open');
  } else {
    $('.menu__item-drop, .sub-menu').addClass('open');
  };
});