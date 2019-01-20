# Notebook theme for WordPress

This is a simple WordPress theme for keeping notes. It is currently in use on [piperhaywood.com](https://piperhaywood.com).

## Description

Post titles are second-class citizens by design. For Standard posts (longer format writing), titles are displayed in the body of the content. For all other formats (aside, image, quote, etc.), titles are only displayed on the post permalink as a breadcrumb.

The Browse page template offers search, year-based post lists, and a tag cloud. The tag cloud displays only tags with greater than one post count. The tag opacity is relative to the tag’s post count (the fewer the posts, the lighter the tag).

The theme makes use of the [Infinite Scroll](https://infinite-scroll.com/) library by Metafizzy under the open source license [GPLv3](https://www.gnu.org/licenses/gpl-3.0.html). The theme uses [Prism.js](https://prismjs.com/index.html) for syntax highlighting.

There are a few additional theme modification options on the WordPress Customizer. “Rainbow” will enable date-specific colours across the site. A theme credit can optionally be removed, and author links can be hidden.

The theme isn’t currently translation-ready. I’ll try to get to this at some point.

The accessibility is nowhere near where I want it to be. That needs to be the priority for the next update.

## Development

Set up a WordPress site locally in a separate site folder. See [multi-environment `wp-config.php` gist](https://gist.github.com/piperhaywood/2a7217964335e22574784153eab1d38b) if useful. In the new WP site you’ve just created, symlink the `/notebook-ph` directory (the built theme) in this project folder in to the `/wp-content/themes` directory. Back in the root of this project folder, run `npm i` to install dependencies. Run `gulp` to build the theme. Run `gulp dev` for development. To set a BrowserSync proxy other than `localhost:8888` (default), run `gulp dev --proxy custom-proxy` (replace `custom-proxy`). 
