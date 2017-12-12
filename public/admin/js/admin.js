$(document).ready(function() {
  $('[aria-controls="spoiler"]').each(function() {
    var $el = $(this).next(".spoiler");
    $(this).click(function() {
      if ($el.is(":visible")) {
        $el.hide();
      } else {
        $el.show();
      }
    })
  })
});