(function($) {

  $('.post').fitVids();

  $pagination = $('.pagination');
  if ($pagination.length) {
    $('.js-infinite-container').infiniteScroll({
      path: '.js-next a',
      append: '.js-article',
      elementScroll: '.js-wrapper',
      hideNav: '.js-pagination'
    });
  }

})(jQuery);