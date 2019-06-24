function handleFirstTab(e) {
  if (e.keyCode === 9) {
    // the "I am a keyboard user" key
    document.body.classList.add("user-is-tabbing");
    window.removeEventListener("keydown", handleFirstTab);
  }
}

var infinite = {
  init: function() {
    var next = document.querySelector(".js-next");
    var container = document.querySelector(".js-infinite-container");
    if (!next || !container) {
      return;
    }
    var infScroll = new InfiniteScroll(container, {
      path: ".js-next a",
      append: ".js-article",
      hideNav: ".js-pagination",
      elementScroll: ".js-wrapper"
    });
    infScroll.on("append", function(response, path, items) {
      // Reset asset HTML due to Infinite Scroll behaviour
      var imgs = items.querySelectorAll("img");
      var audios = items.querySelectorAll("audio");
      var videos = items.querySelectorAll("video");
      var assets = imgs.concat(audios, videos);
      assets.forEach(function(asset) {
        asset.outerHTML = asset.outerHTML;
      });
    });

    var loadingMessage = document.querySelector(".js-infinite-loading");
    var endMessage = document.querySelector(".js-infinite-end");
    infScroll.on("request", function(path) {
      loadingMessage.classList.add("show");
    });
    infScroll.on("last", function(response, path) {
      loadingMessage.classList.remove("show");
      endMessage.classList.add("show");
    });
  }
};

window.addEventListener("keydown", handleFirstTab);
infinite.init();
