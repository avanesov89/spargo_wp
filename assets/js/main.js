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