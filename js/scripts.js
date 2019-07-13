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
      items.forEach(function(item) {
        var imgs = item.querySelectorAll("img");
        var audios = item.querySelectorAll("audio");
        var videos = item.querySelectorAll("video");
        var assetGroups = [imgs, audios, videos];
        assetGroups.forEach(function(group) {
          group.forEach(function(asset) {
            asset.outerHTML = asset.outerHTML;
          });
        });
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
    return infScroll;
  }
};


// Add class so that we can style skip links
function handleFirstTab(e) {
  if (e.keyCode === 9) {
    // the "I am a keyboard user" key
    document.body.classList.add("is-tabbing");
    document.body.classList.remove("is-not-tabbing");
    window.removeEventListener("keydown", handleFirstTab);
  }
}
window.addEventListener("keydown", handleFirstTab);
var infScroll = infinite.init();
