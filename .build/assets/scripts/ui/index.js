// Optionally load settings from JSON
// import { c, color, theme, is_mobile } from './modules/settings.js';
// import './modules/settings';

import './_polyfill';
import './a11y';
import './aria-toggler';
import './link-target';

console.log('---');
console.log('%cDeveloped by', 'font-style: italic; font-size: 12px;');
console.log('%cSay Hello GmbH', 'font-weight: bold; color: #000; font-size: 16px;');
console.log('%chttps://sayhello.ch', 'color: #000; font-size: 12px;');
console.log('---');

// Load script if CSS custom properties are not supported natively
if (!CSS.supports || !CSS.supports('(--foo: bar)')) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/cssvars.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}

// Load script if object-fit is not supported natively
if (!CSS.supports || !CSS.supports('object-fit', 'cover')) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/object-fit.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}

// Load script if dvh is not supported natively
if (!CSS.supports || !CSS.supports('height', '1dvh')) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/vh.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}
