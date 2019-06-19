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

### Composer

PHP dependencies (but not WordPress dependencies like plugins) are loaded using [Composer](https://getcomposer.org/). Use `composer install` when first starting work on the theme, and `composer update` thereafter.

### nodeJS

`node` and node package manager `npm` are required to run the build commands.

Please visit [https://nodejs.org/en/download/](https://nodejs.org/en/download/) and download the latest LTS version of nodeJS.

# Automation: Gulp

This theme comes with some very handy gulp tasks to make your life much easier.

You can install the packages using `npm install`.
```
$ cd path/to/your/project/
$ npm install
```
Afterwards you can use `start`-command to start the default gulp tasks.
```
$ npm start
```

## Feature overview

### Content width

WordPress loads content at an appropriate size - e.g. responsive images or external video embeds - using the `$content_width` variable. This should be modified for your project based on the standard width of a content element in the single blog post view. The definition is in the `Theme` class and can either be modified directly or via the filter `sht/content_width`.

### settings.json

There are shared settings between css and js Files which are stored inside `assets/settings.json`. You can import them into any js module (`import * as settings from '../../../../../assets/settings.json';`) or use them inside any scss file (for example: `$my_easing_speed: $easing_speed;`).

### Styles

This theme uses an [ITCSS architecture](https://www.creativebloq.com/web-design/manage-large-css-projects-itcss-101517528) together with the [BEM naming convention](http://getbem.com/). All `.build/assets/styles/*.scss`-Files will be converted to inside `assets/styles/{$name}.css`-Files.

The Package Class `Assets` enqueues them directly.

- admin.min.css is loaded in the backend. This file is generated from _.build/assets/styles/admin.scss_.
- ui.min.css is loaded in the backend. This file is generated from _.build/assets/styles/ui.scss_.

#### CSS Variables

The CSS will be generated with [CSS Variables](https://dev.to/sarah_chima/an-introduction-to-css-variables-cmj) in the generated stylesheets. The (JavaScript-based) Ponyfill `css-vars-ponyfill` ([source](https://github.com/jhildenbiddle/css-vars-ponyfill)) is included for IE11 support in the frontend. (_Not_ in the admin area!.)

#### Gutenberg Blocks

The Theme is provided with built-in SCSS support for Gutenberg blocks. There is a specific `Gutenberg` Package for some functionality.

The SCSS variable `$block-mode` is defined in _admin.scss_ and _ui.scss_ appropriate to each context, so that the mixins `blocks-frontend` and `blocks-backend` can generate the CSS appropriately for the current context. For example:

```scss
.wp-block-image {
	vertical-align: middle;
}
@include blocks-frontend() {
	.wp-block-image {
		margin-top: 1rem;
		margin-bottom: 1rem;
	}
}
```

**Note** that the call to `@include blocks-frontend()` may not be defined _within_ the `.wp-block-image` definition, but must be included as a separate section. This is because it wraps the CSS with a parent CSS class: `.edit-post-visual-editor` in the backend context and `.c-blocks` in the frontend context.

### Scripts

This theme uses ES6 modules which are converted to ES5 using Babel and bundled using Webpack. The Package Class `Assets` enqueues the resultant fidirectly. For example: all `.build/assets/scripts/ui/*.js`-Files will be bundled to `assets/scripts/ui.js`. There will also be a minified version `assets/scripts/ui.min.js`.


### Fonts

There is a built in Font loading process using base64 encoded woff/woff2 fonts, which are stored inside the local storage of the browser. You can read more here: [https://github.com/SayHelloGmbH/hello-roots/tree/master/.build/assets/fonts](https://github.com/SayHelloGmbH/hello-roots/tree/master/.build/assets/fonts)

### LiveReload

It also uses [LiveReload](http://livereload.com/) to refresh your browser on every change you make.

If you are using Google Chrome there is a pretty helpful extension: [chrome LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)

# Authors
- [Nico Martin](https://github.com/nico-martin)
- [Joel Stüdle](https://github.com/joel-st)
- [Dimitri Suter](https://github.com/gnochi/)
- [Mark Howells-Mead](https://github.com/markhowellsmead/)
