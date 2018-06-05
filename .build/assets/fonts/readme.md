## Convert fonts
All fonts can be placed as `.ttf` inside the `source/`-Folder an should be named like this `{name}-{weight}-{style|optional}.ttf`.  
The font-weight can be numeric (100-900) or weight names: [https://www.w3.org/TR/css-fonts-3/#font-weight-prop](https://www.w3.org/TR/css-fonts-3/#font-weight-prop)

For example:
* `Arial-Bold-italic.ttf`
* `Arial-700.ttf`
* `OpenSans-Normal-italic.ttf`

### commands
```
$ gulp fontsconvert
```
Converts the fonts inside the `source/`-Folder to woff and woff2.
```
$ gulp fontsinline
```
Creates or updates `assets/fonts/fonts-woff.css` and `assets/fonts/fonts-woff2.css` which contain the `@fontface`-rules for all fonts and styles.  
The font itself is included a base64 encoded data url.

## Font loading
**Performance matters!**  

### loadfonts.js
Placed inside `assets/scripts/loadfonts.js`, enqueued inside `classes/class-themeassets.php:94`.

The font files are loaded asynchronous on the first pageload. Yes, there will be a Flash of unstyled Text.  
After the file has loaded, a copy will be stored inside the local storage of the browser.  
The next time the browser requests the same fontfile it will be served from the local storage. And because there is no network request it will be served sinchronous. So after the first pageload there will be no Flash of unstyled Text.