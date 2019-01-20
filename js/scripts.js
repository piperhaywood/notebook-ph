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
    $container.on('append.infiniteScroll', function(event, response, path, items) {
      $(items).find('img').each(function(index, img) {
        img.outerHTML = img.outerHTML;
      });
    });
    $container.on('request.infiniteScroll', function(event, path) {
      $('.js-infinite-loading').addClass('show');
    });
    $container.on('last.infiniteScroll', function(event, response, path) {
      $('.js-infinite-loading').removeClass('show');
      $('.js-infinite-end').addClass('show');
    });
  }

  function handleFirstTab(e) {
    if (e.keyCode === 9) { // the "I am a keyboard user" key
      document.body.classList.add('user-is-tabbing');
      window.removeEventListener('keydown', handleFirstTab);
    }
  }
  window.addEventListener('keydown', handleFirstTab);

})(jQuery);