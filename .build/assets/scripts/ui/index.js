// Optionally load settings from JSON
// import { c, color, theme, is_mobile } from './modules/settings.js';
// import './modules/settings';

import './_polyfill';
import './a11y';
import './aria-toggler';
import './link-target';
import './mobile-menu';

console.log('---');
console.log('%cDeveloped by', 'font-style: italic; font-size: 12px;');
console.log('%cSay Hello GmbH', 'font-weight: bold; color: #000; font-size:20px;');
console.log(
    '%cWant to work with us? Stop by at https://sayhello.ch and Say Hello!',
    'color: #000; font-size: 12px;'
);
console.log('🥷');
console.log('---');

// Load script if there are any images on the page which require Fancybox
const linked_images = document.querySelectorAll(
    'a[href*=".jpg"], a[href*=".png"], a[href*=".gif"], a[href*=".webp"], a[data-fslightbox]'
);

if (!!linked_images.length) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/fslightbox.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}
