# Project Description

This is a boilerplate WordPress theme by [say hello](https://sayhello.ch). It has an object oriented php architecture and comes with some very handy build workflows.

# Getting started

It is distributed under the GNU General Public License v3.0. Or in short: **It's open source**.
You are free to use this starter theme or only parts of it for personal and commercial use!

Just clone this repository and run a search for the following values and replace them with the values for your project.

```
Name:        Hello Theme
Key:         hello-theme
Namespace:   HelloTheme
Prefix:      sht
```

## System requirements

### NodeJS

`node` and node package manager `npm` are required to run the build commands.

Please visit [https://nodejs.org/en/download/](https://nodejs.org/en/download/) and download the latest LTS version of nodeJS.

# Automation: Gulp

This theme comes with some very handy gulp tasks to make your life much easier.

You can install the packages using `npm install`.
```
$ cd path/to/your/project/
$ npm install
```
Afterwards you can use the following command to start the default gulp tasks.
```
$ npm start
```

## Feature overview

### Content width

WordPress loads content at an appropriate size - e.g. responsive images or external video embeds - using the `$content_width` variable. This should be modified for your project based on the standard width of a content element in the single blog post view. The definition is in the `Theme` class and can either be modified directly or via the filter `sht/content_width`.

### settings.json

There are shared settings between CSS and JavaScript files which are stored inside `assets/settings.json`. You can import them into any JavaScript module (`import * as settings from '../../../../../assets/settings.json';`) or use them inside any scss file (for example: `$my_easing_speed: $easing_speed;`).

### Styles

This theme uses an [ITCSS architecture](https://www.creativebloq.com/web-design/manage-large-css-projects-itcss-101517528) together with the [BEM naming convention](http://getbem.com/). All `.build/assets/styles/*.scss` files will be converted to inside `assets/styles/{$name}.css` files.

The Package Class `Assets` enqueues them directly.

- admin-editor.min.css is loaded in the backend. This file is generated from _.build/assets/styles/admin-editor.scss_.
- admin.min.css is loaded in the backend. This file is generated from _.build/assets/styles/admin.scss_.
- ui.min.css is loaded in the backend. This file is generated from _.build/assets/styles/ui.scss_.

#### CSS Variables

The CSS will be generated with [CSS Variables](https://dev.to/sarah_chima/an-introduction-to-css-variables-cmj) in the generated stylesheets. The (JavaScript-based) Ponyfill `css-vars-ponyfill` ([source](https://github.com/jhildenbiddle/css-vars-ponyfill)) is included for IE11 support in the frontend. (_Not_ in the admin area! The Gutenberg Editor doesn't fully support IE11 anyway.)

#### Gutenberg Blocks

The Theme is provided with built-in SCSS support for Gutenberg blocks. There is a specific `Gutenberg` Package for some functionality.

The SCSS variable `$context` is defined in _admin-editor.scss_ (value `edit`) and _ui.scss_ (value `view`) appropriate to each context, so that the mixins `context-view` and `context-edit` can generate the CSS appropriately for the current context. For example:

```scss
.wp-block-image {
	vertical-align: middle;
}
@include context-view() {
	.wp-block-image {
		margin-top: 1rem;
		margin-bottom: 1rem;
	}
}
```

**Note** that the call to `@include context-view()` may not be defined _within_ the `.wp-block-image` definition, but must be included as a separate section. This is due to the CSS namespacing which occurs in the `gulp-editor-styles` process.

#### gulp-editor-styles

Gulp uses the [gulp-editor-styles](https://www.npmjs.com/package/gulp-editor-styles) Node Module to automatically parse and wrap the CSS in an appropriate scope (`.editor-styles-wrapper`) for the Gutenberg editor.

### Scripts

This theme uses ES6 modules which are converted to ES5 using Babel and bundled using Webpack. The Package Class `Assets` enqueues the resultant fidirectly. For example: all `.build/assets/scripts/ui/*.js` files will be bundled to `assets/scripts/ui.js`. There will also be a minified version `assets/scripts/ui.min.js`.


### Fonts

There is a built in Font loading process using base64 encoded woff/woff2 fonts, which are stored inside the local storage of the browser. This avoids the FOUT problem.

Assuming that the fonts you're using are licensed for use in this way, convert the fonts to base64-encoded WOFF and WOFF2 CSS files using [Transfonter](https://transfonter.org/) and then add the code to the files in the [assets/fonts](https://github.com/SayHelloGmbH/hello-roots/tree/master/assets/fonts) folder. Generate the WOFF and WOFF2 versions separately, as you'll need individual CSS files.

These files are then loaded [by JavaScript](https://github.com/SayHelloGmbH/hello-roots/blob/master/src/Package/Assets.php#L124) and stored in the browser's [LocalStorage](https://javascript.info/localstorage). The script checks the asset version number; if you need to force a new version of the files, then update the [`theme_fontver`](https://github.com/SayHelloGmbH/hello-roots/blob/master/assets/settings.json#L38) in the Assets' JSON configuration file.

### LiveReload

It also uses [LiveReload](http://livereload.com/) to refresh your browser on every change you make.

If you are using Google Chrome there is a pretty helpful extension: [chrome LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)

### SVG

SVG support and sanitization was formerly handled directly by the Theme. This feature was removed in 2020 in favour of https://wordpress.org/plugins/safe-svg/.

# Authors
- [Nico Martin](https://github.com/nico-martin)
- [Mark Howells-Mead](https://github.com/markhowellsmead/)
- [Joel Stüdle](https://github.com/joel-st)
- [Dimitri Suter](https://github.com/gnochi/)
