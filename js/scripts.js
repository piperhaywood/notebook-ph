(function($) {

  $('.post').fitVids();

  $('.js-infinite-container').infiniteScroll({
    path: '.pagination__next a',
    append: '.article',
    elementScroll: '.wrapper',
    hideNav: '.pagination'
  });

})(jQuery);