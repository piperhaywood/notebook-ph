(function($) {

  $('.post').fitVids();

  $pagination = $('.pagination');
  if ($pagination.length) {
    $('.js-infinite-container').infiniteScroll({
      path: '.js-next a',
      append: '.js-article',
      hideNav: '.js-pagination'
    });
  }

})(jQuery);