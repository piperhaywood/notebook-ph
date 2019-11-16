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
      hideNav: ".js-pagination"
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

var menu = {
  scroll: window.pageYOffset,
  height: 0,
  init: function() {
    var vm = this;
    var details = document.querySelector(".js-header-details");
    var sum = document.querySelector(".js-header-summary");
    if (!details || !sum) {
      return;
    }

    vm.height = details.clientHeight - sum.clientHeight;
    details.addEventListener("toggle", function(e) {
      var open = e.target.getAttribute("open");
      if (open == null) {
        vm.close(sum, details);
      } else {
        vm.open(sum);
      }
    });

    var closeMenu = document.querySelector(".js-close-menu");
    if (closeMenu) {
      closeMenu.addEventListener("click", function(e) {
        e.preventDefault();
        vm.close(sum, details);
      });
    }

    // TODO trap focus
    // For now, there is a “close menu” button at the base of the menu
  },
  close: function(elem, details) {
    var vm = this;
    document.body.classList.remove("is-header-open");
    details.removeAttribute("open");
    elem.setAttribute("aria-expanded", "false");
    window.scrollTo(0, vm.scroll);
  },
  open: function(elem) {
    var vm = this;
    // Save the scroll position so that we can reset it when header is closed and body is “unfrozen”
    vm.scroll = window.pageYOffset;
    document.body.classList.add("is-header-open");
    elem.setAttribute("aria-expanded", "true");
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

// Add class if browser doesn’t support open/close of details
if (!("open" in document.createElement("details"))) {
  document.body.classList.add("no-details");
}

var replyLinks = document.querySelectorAll(".comment-reply-link");
var replyDetails = document.querySelector("#reply");
var replyInput = document.querySelector("#comment");
if (replyDetails && replyLinks) {
  replyLinks.forEach(function(link) {
    link.addEventListener("click", function(e) {
      e.preventDefault();
      replyDetails.setAttribute("open", "true");
      replyDetails.scrollIntoView({ behavior: "smooth" });
      replyInput.focus();
    });
  });
}

var infScroll = infinite.init();
menu.init();
