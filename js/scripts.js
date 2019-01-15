(function($) {

  $next = $('.js-next');
  if ($next.length) {
    var $container = $('.js-infinite-container');
    $container.infiniteScroll({
      path: '.js-next a',
      append: '.js-article',
      hideNav: '.js-pagination',
      elementScroll: '.js-wrapper'
    });
    $container.on('request.infiniteScroll', function(event, path) {
      $('.js-infinite-loading').addClass('show');
    });
    $container.on('last.infiniteScroll', function(event, response, path) {
      $('.js-infinite-loading').removeClass('show');
      $('.js-infinite-end').addClass('show');
    });
  }


})(jQuery);