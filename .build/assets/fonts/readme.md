All fonts as ttf can be placed inside the `ttf/` Folder an should be named like this `{name}-{weight}.ttf`.
If it is italic, you can also specify the font style `{name}-{weight}-{style}.ttf`.

For example:
* `Arial-Bold-italic.ttf`
* `Arial-700.ttf`
* `OpenSans-Regular-italic.ttf`

To compile the font just run `gulp fonts` inside the root folder of the project. This will convert the ttf to woff and woff2 and it will create or update `assets/fonts/fonts-woff.css` and `assets/fonts/fonts-woff2.css` which contains the `@fontface`-rules for all fonts and styles. The font itself is saved as included a base64 encoded data url.

These files will then be included using an advanced font loading: `classes/class-themeassets.php:94`.