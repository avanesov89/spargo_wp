const myModal = new HystModal({
    linkAttributeName: false,
    catchFocus: false,
    closeOnEsc: true,
    backscroll: true,
  });
  (function initModal() {
    myModal.config.linkAttributeName = 'data-hystmodal';
    myModal.config.beforeOpen = function(modal){
      const $container = $(modal.openedWindow);
      if ($container.has('modal-vacancy')) {
        const $form = $container.find('form');

        $form.addClass('hystmodal__form main__form');

        $.each($form.find('> p'), function () {
          const p = $(this);
          if (p.next('.main__form-files').length > 0) {
            const pContent = p.html();

            p.next('.main__form-files').wrap('<div class="main__form-field" />').find('input[name="vacancy-file"').after('<label class="field-file__label" for="vacancy-file">\n' +
              '<div class="field-file__icon"></div>\n' +
              '<span class="field-file__label--text">Выберите резюме для загрузки</span>\n' +
              '</label>');
            p.next('.main__form-field').prepend(pContent);
            p.remove();
          } else {
            p.addClass('main__form-field');
          }

        });

        $form.find('.wpcf7-submit').addClass('main__button btn-reset');
      }

    };
    myModal.init();
  })();