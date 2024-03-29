# Project no longer maintained

**This project is no longer maintained**. Please use https://github.com/sayhellogmbh/hello-fse instead.

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

You can install the packages using `npm install`. The current required versions of Node and NPM are included in the _package.json_ file.

```bash
$ cd path/to/your/project/
$ npm install
```

Afterwards you can use the following command to start the default gulp tasks.

```bash
$ npm start
```

(Installed node modules are explicitly excluded from the git repository.)

# Feature overview

## WordPress 5.9+

This theme supports WordPress from version 5.9 onwards. Older versions of WordPress are not supported because of the theme's basis on Full-Site Editing.

## Advanced Custom Fields

The theme is currently dependent on the [Advanced Custom Fields](https://www.advancedcustomfields.com/) plugin. This plugin must be installed and activated before the theme is activated.

## Debug mode

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

## Full-site editing

This theme is set up to use the Full Site Editing feature built into WordPress since version 5.8 and extended in WordPress 5.9. Block templates are created containing a series of blocks and the theme contains a few block template parts, where a combination of blocks is used across multiple templates.

The essential block templates are located in the _block-templates_ folder. Block template parts are located in the _block-template-parts_ folder.

PHP files which were formerly in use for templating - like _archive.php_ or _single.php_ - will be **ignored** if full-site editing is active.

### Free online course for users and developers

For more information and a free online-course about Full Site Editing, which will give you a good grounding in the coding techniques implemented here, please visit [fullsiteediting.com](https://fullsiteediting.com/). The site is maintained by WordPress Core contributor [Carolina Nymark](https://themesbycarolina.com/) and is not affiliated with Say Hello.

### theme.json and settings.json

The _[theme.json](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/)_ file was introduced with WordPress 5.8 as part of the technology for [Full Site Editing](https://make.wordpress.org/design/handbook/focuses/full-site-editing/). This file contains settings for controlling both the editor and some of the site output.

_assets/settings.json_ is a non-standard settings file, which forms part of the specific logic of Hello Roots. There are shared settings between CSS and JavaScript files which are stored inside this file. You can import them into any JavaScript module (`import settings from '../../../../../assets/settings.json';`), use them inside any scss file (for example: `$my_easing_speed: $easing_speed;`), or load them into PHP using the methods `getThemeJson` or `getSettings` in the Theme class.

You can also load the contents of the _theme.json_ file into SCSS and/or JavaScript by the same means. For example, `import theme_json from '../../../../assets/theme.json';`. This will currently throw an error from `sass` because of the `$schema` entry key. If you really need to import _theme.json_ then remove the `$schema` entry. (This entry is valuable because it validates the structure of the JSON file automatically in your IDE. Further details are [here](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/#developing-with-theme-json).)

The import functionality in SCSS and JavaScript is part of the build process. It uses [gulp-sass-import-json](https://www.npmjs.com/package/gulp-sass-import-json) by [Renat Gafarov](https://www.npmjs.com/~acusticdemon).

#### Unit and block section gutter

(In the theme development community, it's common to refer as the various settings in dot notation; for example `settings.color.background`.)

-   `settings.custom.spacing.unit`: the standard unit from which many spacings and scalings are calculated. Uses the WordPress `blockGap` standard CSS property `--wp--style--block-gap` by default.
-   `settings.custom.spacing.outer-gutter`: the gap to the left and right of the content blocks (usually only visible in mobile).

### HTML structure

Hello Roots delivers a standard set of [templates](https://github.com/SayHelloGmbH/hello-roots/tree/master/templates) and [template parts](https://github.com/SayHelloGmbH/hello-roots/tree/master/parts) for the most common requirements. This can be (and should be) modified to suit the project and theme.

The HTML structure of the templates is kept as simple as possible in the unchanged version of the theme. The **masthead** is the banner across the top of the page which usually contains the navigation, and the **footer** is the section at the bottom of each page. Each of these areas are contained within their own template parts.

The `main` element contains the main body of the page content and the editorially-created content is output by the [post content block](https://wordpress.org/support/article/post-content-block/).

#### Gutter for smaller screen sizes

Direct children of the post content block are assigned [a gutter](https://github.com/SayHelloGmbH/hello-roots/blob/master/.build/assets/styles/_____elements/_guttered.scss) to the left and right, so that they don't hit the edge of the screen at smaller screen sizes. Direct children of the post content block which have been assigned with full-width alignment receive a negative margin on the left and right to offset the gutter. The gutter is defined in the [custom spacing section of theme.json](https://github.com/SayHelloGmbH/hello-roots/blob/master/theme.json#L79).

#### Footer

The **footer** is forced to the bottom edge of the browser on shorter pages through the use of `display: flex` on the `.wp-site-blocks` element.

    .wp-site-blocks
      .c-masthead
      .c-main
        .wp-block-post-content
      .c-footer

#### Template parts

##### Template part wrapper is removed

By default, WordPress wraps full-site-editing template parts with a `div`. The [code in the Theme](https://github.com/SayHelloGmbH/hello-roots/blob/master/src/Block/TemplatePart.php#L27) removes this element, in order to maintain a clean HTML structure.

Assigning a class name to the template part block using the CSS class name field in the Editor **will not work**. If a template part needs to contain a wrapper with a specific class name, this should be applied using a group block _inside_ the template part file. (e.g. the [masthead](https://github.com/SayHelloGmbH/hello-roots/blob/master/parts/header.html).)

#### Translatability

The current [beta version 3.2](https://polylang.pro/its-official-polylang-3-2-is-available/) of the translation plugin [Polylang Pro](https://polylang.pro/) supports the direct translation of template parts (but not templates). If the fixed templates in the theme contain a string which may need to be translated, move this section to its own template part.

## Breakpoints

Breakpoints are read in from _assets/settings.json_ by Sass, and generate CSS properties like `--constraint-wide`. These are used in your own CSS. The values used by WordPress Core, however, come from the content width settings in your _theme.json_ file.

## Content width

WordPress loads external content - e.g. responsive images or external video embeds - at an appropriate size using the `$content_width` variable. Since the introduction of _[theme.json](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/)_, this variable is set from the value of `settings.layout.contentSize` in the _theme.json_ file. Modify the value of this entry based on the standard width of a content element in the single blog post view.

In order to allow wide- and full- width content, ensure that the correct value is set for `settings.layout.wideSize`.

If you want to use CSS properties like `--constraint-wide` in your CSS, then make sure that the same breakpoint values for `narrow` and `wide` are set in settings.json as you have set in `settings.layout.contentSize` and `settings.layout.wideSize`.

## Styles

This theme uses an [ITCSS architecture](https://www.creativebloq.com/web-design/manage-large-css-projects-itcss-101517528) together with the [BEM naming convention](http://getbem.com/). All _.build/assets/styles/\*.scss_ files will be converted to sourcemapped `assets/styles/{$name}.css` files. Minified versions (without source mapping) will also be generated.

The Package Class `Assets` enqueues these files directly.

-   admin-editor.min.css is loaded in the Block Editor. This file is generated from _.build/assets/styles/admin-editor.scss_.
-   admin.min.css is loaded in all views of WordPress Admin. The contents of this file should **not** contain styling for the blocks in the Block Editor. This file is generated from _.build/assets/styles/admin.scss_.
-   ui.min.css is loaded in the frontend of the website. This file is generated from _.build/assets/styles/ui.scss_.

### Context variables in SCSS

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

### Custom Properties

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

### Colours

The colour selection for blocks in the editor is defined within the `settings.color.palette` entry of _theme.json_. These values can also be overridden for specific block types. (e.g. if you only want to allow the selection of black or blue on _core/heading_ blocks.) WordPress generates CSS custom properties for the values: for example, `--wp--preset--color--red`. Hello Roots does not interfere with the generation of these class names.

If you need to define colours which generate CSS custom properties, but which are _not_ to be displayed to the user for editorial selection, then add them to the definitions for `theme_colors` in _assets/settings.json_. The SCSS file _colors.scss_ in the overrides folder generates CSS custom properties with the syntax `--sht--color--{name}` or `--sht--color--{name}-{variant}` for use in theme CSS.

### gulp-editor-styles

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

### The Stack and block gap

The stacking [placeholder selector](https://sass-lang.com/documentation/style-rules/placeholder-selectors) `%h-stack` is used via `@extend` to create a [stack](https://every-layout.dev/layouts/stack/) of elements, in which the top and bottom margins are initially set to zero. Then, every element which has a predecessor receives a top margin. This allows any element containing children to neatly and regularly “stack“ its children with equal spacing, with one simple CSS rule. This rule can be used widely throughout the site, avoiding unnecessary re-definition by referring to the same placeholder selector every time.

`%h-stack` uses the CSS custom property `--wp--style-block-gap` which is implemented by WordPress Core. ([More information about Block Gap](https://fullsiteediting.com/lessons/theme-json-layout-and-spacing-options/#h-blockgap).) In the event that a specific element needs the same logic to be applied but with a different spacing, then use the `%h-stack` rule and set the `--wp--style-block-gap` CSS custom property to the value you need. You can alternatively use one of the pre-defined rules like `%h-stack--medium`, which do the same thing but which allow a regular, logically-scaled layout logic.

```scss
.wp-block-post-content {
    @extend %h-stack;
}

.c-main {
    @extend %h-stack;
}

ul {
    @extend %h-stack;
    --wp--style-block-gap: 5px;
}

.c-random-component {
    @extend %h-stack--medium;
}
```

## Gutenberg Blocks

The Theme is provided with built-in SCSS and Webpack support for developing Gutenberg blocks using React. There is a specific PHP `Gutenberg` Package for some functionality.

### JavaScript for Blocks

Blocks built with JavaScript are usually programmed in JSX syntax. These are converted to ES5 using Babel and bundled using Webpack.

The NPM package _@wordpress/dependency-extraction-webpack-plugin_ intelligently recognises dependencies in the JavaScript from the `@wordpress` namespace, for example `import { registerBlockType } from '@wordpress/blocks';`. This Webpack plugin defines the WordPress block editor scripts as _external_ dependencies within the context of block editor scripts. This means that dependencies are **not** compiled into the block scripts. (Because they are already loaded by WordPress' own scripts in the editor environment.)

The `css-loader` and `css-loader` NPM packages provide support for CSS in JavaScript. (If you must! 😉) This support is primarily intended for use in individual frontend scripts, not as a generic solution for adding CSS to the frontend. Create all CSS for the editor through the SCSS build process.

```javascript
import 'style.css';
```

## Scripts

This theme uses ES6 modules which are converted to ES5 using Babel and bundled using Webpack. The Package Class `Assets` enqueues the resultant files. For example: all _.build/assets/scripts/ui/\*.js_ files will be bundled to _assets/scripts/ui.js_. A minified version _assets/scripts/ui.min.js_ will also be generated. Block editor scripts are enqueued by the `Gutenberg` Package.

## Fonts

There is a built in Font loading process using base64-encoded woff/woff2 fonts, which are stored inside the local storage of the browser when a page on the site is first loaded by the browser. This helps to avoid [FOUT](https://css-tricks.com/fout-foit-foft/) problems.

Assuming that the fonts you're using are licensed for use in this way, convert the fonts to base64-encoded WOFF and WOFF2 CSS files using [Transfonter](https://transfonter.org/) and then add the code to the files in the [assets/fonts](https://github.com/SayHelloGmbH/hello-roots/tree/master/assets/fonts) folder. Generate the WOFF and WOFF2 versions separately, as you'll need individual CSS files.

These files are then loaded by JavaScript injected using the [Assets Package](https://github.com/SayHelloGmbH/hello-roots/blob/master/src/Package/Assets.php) and stored in the browser's [LocalStorage](https://javascript.info/localstorage). The script checks the asset version number. If you need to force a new version of the font files for all site visitors, then update the value of `theme_fontver` in the [settings.json configuration file](https://github.com/SayHelloGmbH/hello-roots/blob/master/assets/settings.json). Only the [appropriate file version](https://caniuse.com/woff2) for the current browser (usually WOFF2) is actually loaded.

(If you don't need to support IE11, then you don't need WOFF. [WOFF2 is supported](https://caniuse.com/woff2) by all modern browsers.)

## LiveReload

The build process uses [LiveReload](http://livereload.com/) to refresh your browser when you modify any JavaScript or CSS files.

If you are using Google Chrome there is a pretty helpful extension: [Chrome LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)

## SVG

SVG support and sanitization was formerly handled directly by the Theme. This feature was removed in 2020 in favour of https://wordpress.org/plugins/safe-svg/. Install and use this plugin if users need to upload and integrate SVGs to the site through the editor and the media manager.

The build process will automatically parse and minify any SVG files added to the _assets/img/_ folder using the [gulp-svgmin](https://www.npmjs.com/package/gulp-svgmin) NPM package if the gulp watcher is running. Link to the minified versions in your CSS.

# Authors

-   [Nico Martin](https://github.com/nico-martin)
-   [Mark Howells-Mead](https://github.com/markhowellsmead/)
-   [Joel Stüdle](https://github.com/joel-st)
-   <s>[Dimitri Suter](https://github.com/gnochi/)</s> (Dimitri is a former contributor)
