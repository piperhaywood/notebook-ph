// Add class so that we can style skip links
function handleFirstTab(e) {
  if (e.keyCode === 9) {
    document.body.classList.add("is-tabbing");
    document.body.classList.remove("is-not-tabbing");
    window.removeEventListener("keydown", handleFirstTab);
  }
}

const infinite = {
  init() {
    const next = document.querySelector(".js-next");
    const container = document.querySelector(".js-infinite-container");
    if (!next || !container) {
      return;
    }
    const infScroll = new InfiniteScroll(container, {
      path: ".js-next a",
      append: ".js-article",
      hideNav: ".js-pagination"
    });

    infScroll.on("append", (response, path, items) => {
      // Reset asset HTML due to Infinite Scroll behaviour
      items.forEach(item => {
        let imgs = item.querySelectorAll("img");
        let audios = item.querySelectorAll("audio");
        let videos = item.querySelectorAll("video");
        let assetGroups = [imgs, audios, videos];
        assetGroups.forEach(group => {
          group.forEach(asset => {
            asset.outerHTML = asset.outerHTML;
          });
        });
      });
    });

    const loadingMessage = document.querySelector(".js-infinite-loading");
    const endMessage = document.querySelector(".js-infinite-end");
    infScroll.on("request", path => {
      loadingMessage.classList.add("show");
    });
    infScroll.on("last", (response, path) => {
      loadingMessage.classList.remove("show");
      endMessage.classList.add("show");
    });
    return infScroll;
  }
};

const menu = {
  scroll: window.pageYOffset,
  height: 0,
  init() {
    const vm = this;
    const details = document.querySelector(".js-header-details");
    const sum = document.querySelector(".js-header-summary");
    if (!details || !sum) {
      return;
    }

    vm.height = details.clientHeight - sum.clientHeight;
    details.addEventListener("toggle", e => {
      let open = e.target.getAttribute("open");
      if (open == null) {
        vm.close(sum, details);
      } else {
        vm.open(sum);
      }
    });

    const closeMenu = document.querySelector(".js-close-menu");
    if (closeMenu) {
      closeMenu.addEventListener("click", e => {
        e.preventDefault();
        vm.close(sum, details);
      });
    }

    // TODO trap focus
    // For now, there is a “close menu” button at the base of the menu
  },
  close(elem, details) {
    const vm = this;
    document.body.classList.remove("is-header-open");
    details.removeAttribute("open");
    elem.setAttribute("aria-expanded", "false");
    window.scrollTo(0, vm.scroll);
  },
  open(elem) {
    const vm = this;
    // Save the scroll position so that we can reset it when header is closed and body is “unfrozen”
    vm.scroll = window.pageYOffset;
    document.body.classList.add("is-header-open");
    elem.setAttribute("aria-expanded", "true");
  }
};

const replies = {
  init() {
    const links = document.querySelectorAll(".comment-reply-link");
    const details = document.querySelector("#reply");
    const input = document.querySelector("#comment");
    if (!details || !links || !input) {
      return;
    }
    links.forEach(link => {
      link.addEventListener("click", e => {
        e.preventDefault();
        details.setAttribute("open", "true");
        details.scrollIntoView({ behavior: "smooth" });
        input.focus();
      });
    });
  }
};

// Add class if browser doesn’t support open/close of details
if (!("open" in document.createElement("details"))) {
  document.body.classList.add("no-details");
}
window.addEventListener("keydown", handleFirstTab);
infinite.init();
menu.init();
replies.init();
