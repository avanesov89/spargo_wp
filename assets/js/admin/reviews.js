/**
 * Load media uploader on pages with our custom metabox
 */
jQuery(document).ready(function ($) {

  'use strict';

  // Instantiates the variable that holds the media library frame.
  var metaImageFrame;

  // Runs when the media button is clicked.
  $('body').click(function (e) {

    // Get the btn
    var btn = e.target;

    // Check if it's the upload button
    if (!btn || !$(btn).attr('data-media-uploader-target')) return;

    // Get the field target
    var field = $(btn).data('media-uploader-target');

    // Prevents the default action from occuring.
    e.preventDefault();

    // Sets up the media library frame
    metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
      title: meta_image.title,
      button: { text: 'Выбрать это изображение' },
    });

    metaImageFrame.on('open', function () {
      // On open, get the id from the hidden input
      // and select the appropiate images in the media manager
      var selection = metaImageFrame.state().get('selection');
      var ids = $(field).val().split(',');
      ids.forEach(function (id) {
        var attachment = wp.media.attachment(id);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      });

    });

    // Runs when an image is selected.
    metaImageFrame.on('select', function () {

      // Grabs the attachment selection and creates a JSON representation of the model.
      var media_attachment = metaImageFrame.state().get('selection').first().toJSON();
      
      // Sends the attachment URL to our custom image input field.
      $(field).val(media_attachment.id);
      $('[data-media-input-preview]').hide();
    });

    // Opens the media library frame.
    metaImageFrame.open();

  });

  $('body').click(function (e) {
    // Get the btn
    var btn = e.target;

    // Check if it's the upload button
    if (!btn || !$(btn).attr('data-media-input-target')) return;

    // Get the field target
    var field = $(btn).data('data-media-input-target');

    // Prevents the default action from occuring.
    e.preventDefault();

    $(field).val(0);

    $('[data-media-input-preview]').hide();
  });

});