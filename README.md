# Notebook theme for WordPress

This is a simple, translation-ready WordPress theme for keeping notes. It is currently in use on [piperhaywood.com](https://piperhaywood.com).

## Description

Post titles are purposefully obscured. For Standard posts (longer format writing), titles are displayed in the body of the content. For all other formats (aside, image, quote, etc.), titles are only displayed on the post permalink as a breadcrumb.

The theme makes use of the [Infinite Scroll](https://infinite-scroll.com/) library by Metafizzy under the open source license [GPLv3](https://www.gnu.org/licenses/gpl-3.0.html). The theme uses [Prism.js](https://prismjs.com/index.html) for syntax highlighting.

## Theme options

In the WordPress Customiser, you can adjust:

- The short site title that is displayed in the header on archive pages
- The copyright text displayed in the menu
- The text displayed at the end of infinite scroll
- A blog introduction
- Whether or not the theme credit is displayed
- Whether or not the author is displayed
- Whether or not the theme should use the rainbow colour scheme

Two shortcodes are available for use in the WordPress editor. The shortcode `[notebooksearch]` displays a search form, and the shortcode `[notebookindex]` displays an alphabetical index of terms. The Index shortcode can be passed attributes that modify the included taxonomies, the post count threshold, and whether or not year archive links are displayed. For example, `[notebookindex taxonomy="category" years="false" count="2"]` will pull through only categories with a post count of at least 2 and no year archive links. If no attributes are passed to the `notebookindex` shortcode, then these default attributes will be used: `[notebookindex taxonomy="post_tag, category, post_format" years="true" count="1"]`.

## Development

Set up a WordPress site locally in a separate site folder. See [multi-environment `wp-config.php` gist](https://gist.github.com/piperhaywood/2a7217964335e22574784153eab1d38b) if useful. In the new WP site you’ve just created, symlink the `/notebook-ph` directory (the built theme) in this project folder in to the `/wp-content/themes` directory. Back in the root of this project folder, run `npm i` to install dependencies. Run `gulp` to build the theme. Run `gulp dev` for development. To set a BrowserSync proxy other than `localhost:8888` (default), run `gulp dev --proxy custom-proxy` (replace `custom-proxy`).
