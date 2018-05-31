All fonts as ttf can be placed as .ttf inside the `ttf/` Folder an should be named like this `{name}-{weight}.ttf`.
If it is italic, you can also specify the font style `{name}-{weight}-{style}.ttf`.
The font-weight can be numeric (1-900) or weight names: [https://www.w3.org/TR/css-fonts-3/#font-weight-prop](https://www.w3.org/TR/css-fonts-3/#font-weight-prop)

For example:
* `Arial-Bold-italic.ttf`
* `Arial-700.ttf`
* `OpenSans-Normal-italic.ttf`

To compile the font just run `gulp fontsconvert` to convert them to woff and woff2 and then `gulp fontsinline` inside the root folder of the project. This will create or update `assets/fonts/fonts-woff.css` and `assets/fonts/fonts-woff2.css` which contains the `@fontface`-rules for all fonts and styles. The font itself is saved as included a base64 encoded data url.

These files will then be included using an advanced font loading: `classes/class-themeassets.php:94`.