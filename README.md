# Project Description

This is a boilerplate WordPress theme by [say hello](https://sayhello.ch). It has an object oriented php architecture and comes with some very handy build workflows for CSS and JavaScript.

# Getting started

This code is distributed under the GNU General Public License v3.0. Or in short: **it's open source**. You are free to use this starter theme or only parts of it for personal and commercial use!

## System requirements

### NodeJS

`node` and node package manager `npm` are required to run the build commands.

Please visit [https://nodejs.org/en/download/](https://nodejs.org/en/download/) and download the latest LTS version of nodeJS.

## Automation: Gulp

This theme comes with some very handy gulp tasks to make your life much easier.

You can install the packages using `npm install`.

```bash
$ cd path/to/your/project/
$ npm install
```

Afterwards you can use the following command to start the default gulp tasks.

```bash
$ npm start
```

(Installed node modules are explicitly excluded from the git repository.)

## Feature overview

### Advanced Custom Fields

The theme is currently dependent on the [Advanced Custom Fields](https://www.advancedcustomfields.com/) plugin. This plugin must be installed and activated before the theme is activated.

### Debug mode

Set `WP_DEBUG` to `true` in _wp-config.php_ in the development environment. This will load the unminified and sourcemapped assets (JavaScript and CSS) for easier debugging.

```php
define('WP_DEBUG', true);
```

If you need to work in debug mode but suppress PHP notices and warnings, you can additionally turn them off.

```php
define('WP_DEBUG_DISPLAY', false);
```

You can keep a log of all notices, warnings and errors in _wp-content/error.log_ by turning on the debug log.

```php
define('WP_DEBUG_LOG', true);
```

### Full-site editing

This theme is set up to use the Full Site Editing feature built into WordPress since version 5.8 and extended in WordPress 5.9. Block templates are created containing a series of blocks and the theme contains a few block template parts, where a combination of blocks is used across multiple templates.

The essential block templates are located in the _block-templates_ folder. Block template parts are located in the _block-template-parts_ folder.

PHP files which were formerly in use for templating - like _archive.php_ or _single.php_ - will be **ignored** if full-site editing is active.

#### Free online course for users and developers

For more information and a free online-course about Full Site Editing, which will give you a good grounding in the coding techniques implemented here, please visit [fullsiteediting.com](https://fullsiteediting.com/). The site is maintained by WordPress Core contributor [Carolina Nymark](https://themesbycarolina.com/) and is not affiliated with Say Hello.

#### theme.json and settings.json

The _[theme.json](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/)_ file was introduced with WordPress 5.8 as part of the technology for [Full Site Editing](https://make.wordpress.org/design/handbook/focuses/full-site-editing/). This file contains settings for controlling both the editor and some of the site output.

_assets/settings.json_ is a non-standard settings file, which forms part of the specific logic of Hello Roots. There are shared settings between CSS and JavaScript files which are stored inside this file. You can import them into any JavaScript module (`import settings from '../../../../../assets/settings.json';`), use them inside any scss file (for example: `$my_easing_speed: $easing_speed;`), or load them into PHP using the methods `getThemeJson` or `getSettings` in the Theme class.

You can also load the contents of the _theme.json_ file into SCSS and/or JavaScript by the same means. For example, `import theme_json from '../../../../assets/theme.json';`

The import functionality in SCSS and JavaScript is part of the build process. It uses [gulp-sass-import-json](https://www.npmjs.com/package/gulp-sass-import-json) by [Renat Gafarov](https://www.npmjs.com/~acusticdemon).

##### Example for PHP

```php
$settings = sht_theme()->getThemeJson();
var_dump($settings['custom']['breakpoint']['tablet'] ?? 'not defined');
```

### Content width

WordPress loads external content - e.g. responsive images or external video embeds - at an appropriate size using the `$content_width` variable. Since the introduction of [theme.json](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/), this variable is set from the value of `settings.layout.contentSize` in the theme.json file. Modify the value of this entry based on the standard width of a content element in the single blog post view.

In order to allow wide- and full- width content, ensure that the correct value is set for `settings.layout.wideSize`.

### Styles

This theme uses an [ITCSS architecture](https://www.creativebloq.com/web-design/manage-large-css-projects-itcss-101517528) together with the [BEM naming convention](http://getbem.com/). All _.build/assets/styles/\*.scss_ files will be converted to sourcemapped `assets/styles/{$name}.css` files. Minified versions (without source mapping) will also be generated.

The Package Class `Assets` enqueues these files directly.

-   admin-editor.min.css is loaded in the Block Editor. This file is generated from _.build/assets/styles/admin-editor.scss_.
-   admin.min.css is loaded in all views of WordPress Admin. The contents of this file should **not** contain styling for the blocks in the Block Editor. This file is generated from _.build/assets/styles/admin.scss_.
-   ui.min.css is loaded in the frontend of the website. This file is generated from _.build/assets/styles/ui.scss_.

#### Custom Properties

The CSS will be generated with [CSS Custom Properties](https://dev.to/sarah_chima/an-introduction-to-css-variables-cmj) in the generated stylesheets. The (JavaScript-based) Ponyfill `css-vars-ponyfill` ([source](https://github.com/jhildenbiddle/css-vars-ponyfill)) is included for IE11 support in the frontend. (_Not_ in the admin area! Support for Internet Explorer is being phased out of WordPress Admin.)

CSS Custom Properties are currently defined on the `body` element. This is in order to use the same logic as WordPress Core. If you need to support IE11 through `css-vars-ponyfill` or make an alias for a CSS Custom Property generated by WordPress (e.g. colours) which is applied to `body`, then amend the definitions to ensure they're applied to both `body` and `:root`.

For example:

```css
body,
:root {
    --my-custom-property1: #f00;
    --my-custom-property2: var(--wp--preset--color--red);
}
```

#### Colours

The colour selection for blocks in the editor is defined within the `settings.color.palette` entry of theme.json. These values can also be overridden for specific block types. (e.g. if you only want to allow the selection of black or blue on _core/heading_ blocks.) WordPress generates CSS custom properties for the values: for example, `--wp--preset--color--red`. Hello Roots does not interfere with the generation of these class names.

If you need to define colours which generate CSS custom properties, but which are _not_ to be displayed to the user for editorial selection, then add them to the definitions for `theme_colors` in _assets/settings.json_. The SCSS file _colors.scss_ in the overrides folder generates CSS custom properties with the syntax `--sht--color--{name}` or `--sht--color--{name}-{variant}` for use in theme CSS.

#### Gutenberg Blocks

The Theme is provided with built-in SCSS and Webpack support for developing Gutenberg blocks using React. There is a specific PHP `Gutenberg` Package for some functionality.

##### SCSS

The SCSS variable `$context` is defined in _admin.scss_ (value `admin`), _admin-editor.scss_ (value `edit`) and _ui.scss_ (value `view`) appropriate to each context, so that the mixins `context-view`, `context-edit` and `context-admin` can generate the CSS appropriately for the current context. For example:

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

**Note** that the call to `@include context-view()` cannot be defined _within_ the `.wp-block-image` definition. It must be included **as a separate section**. This is due to the CSS namespacing which occurs in the `gulp-editor-styles` process.

##### JavaScript for Blocks

Blocks built with JavaScript are usually programmed in JSX syntax. These are converted to ES5 using Babel and bundled using Webpack.

The NPM package _@wordpress/dependency-extraction-webpack-plugin_ intelligently recognises dependencies in the JavaScript from the `@wordpress` namespace, for example `import { registerBlockType } from '@wordpress/blocks';`. This Webpack plugin defines the WordPress block editor scripts as _external_ dependencies within the context of block editor scripts. This means that dependencies are **not** compiled into the block scripts. (Because they are already loaded by WordPress' own scripts in the editor environment.)

The `css-loader` and `css-loader` NPM packages provide support for CSS in JavaScript. (If you must! 😉) This support is primarily intended for use in individual frontend scripts, not as a generic solution for adding CSS to the frontend. Create all CSS for the editor through the SCSS build process.

```javascript
import 'style.css';
```

#### gulp-editor-styles

Gulp uses the [gulp-editor-styles](https://www.npmjs.com/package/gulp-editor-styles) Node Module to automatically parse and wrap the CSS in an appropriate scope (`.editor-styles-wrapper`) for the Gutenberg editor. Any CSS definition assigned to `body` in CSS which will be loaded in the editor will be converted to use this class name.

In SCSS:

```scss
body {
    background-color: red;
}
```

Output:

```css
.editor-styles-wrapper {
    background-color: red;
}
```

### Scripts

This theme uses ES6 modules which are converted to ES5 using Babel and bundled using Webpack. The Package Class `Assets` enqueues the resultant files. For example: all _.build/assets/scripts/ui/\*.js_ files will be bundled to _assets/scripts/ui.js_. A minified version _assets/scripts/ui.min.js_ will also be generated. Block editor scripts are enqueued by the `Gutenberg` Package.

### Fonts

There is a built in Font loading process using base64-encoded woff/woff2 fonts, which are stored inside the local storage of the browser when a page on the site is first loaded by the browser. This helps to avoid [FOUT](https://css-tricks.com/fout-foit-foft/) problems.

Assuming that the fonts you're using are licensed for use in this way, convert the fonts to base64-encoded WOFF and WOFF2 CSS files using [Transfonter](https://transfonter.org/) and then add the code to the files in the [assets/fonts](https://github.com/SayHelloGmbH/hello-roots/tree/master/assets/fonts) folder. Generate the WOFF and WOFF2 versions separately, as you'll need individual CSS files.

These files are then loaded by JavaScript injected using the [Assets Package](https://github.com/SayHelloGmbH/hello-roots/blob/master/src/Package/Assets.php) and stored in the browser's [LocalStorage](https://javascript.info/localstorage). The script checks the asset version number. If you need to force a new version of the font files for all site visitors, then update the value of `theme_fontver` in the [settings.json configuration file](https://github.com/SayHelloGmbH/hello-roots/blob/master/assets/settings.json). Only the [appropriate file version](https://caniuse.com/woff2) for the current browser (usually WOFF2) is actually loaded.

(If you don't need to support IE11, then you don't need WOFF. [WOFF2 is supported](https://caniuse.com/woff2) by all modern browsers.)

### LiveReload

The build process uses [LiveReload](http://livereload.com/) to refresh your browser when you modify any JavaScript or CSS files.

If you are using Google Chrome there is a pretty helpful extension: [Chrome LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)

### SVG

SVG support and sanitization was formerly handled directly by the Theme. This feature was removed in 2020 in favour of https://wordpress.org/plugins/safe-svg/. Install and use this plugin if users need to upload and integrate SVGs to the site through the editor and the media manager.

The build process will automatically parse and minify any SVG files added to the _assets/img/_ folder using the [gulp-svgmin](https://www.npmjs.com/package/gulp-svgmin) NPM package if the gulp watcher is running. Link to the minified versions in your CSS.

# Authors

-   [Nico Martin](https://github.com/nico-martin)
-   [Mark Howells-Mead](https://github.com/markhowellsmead/)
-   [Joel Stüdle](https://github.com/joel-st)
-   <s>[Dimitri Suter](https://github.com/gnochi/)</s> (Dimitri is a former contributor)
