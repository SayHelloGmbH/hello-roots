// import domReady from '@wordpress/dom-ready';
import { unregisterBlockStyle } from '@wordpress/blocks';

// domReady(() => {
//     registerBlockStyle('core/heading', {
//         name: 'special',
//         label: 'Special',
//     });
// });

window.addEventListener('load', () => {
    unregisterBlockStyle('core/button', 'fill');
    unregisterBlockStyle('core/button', 'outline');
    unregisterBlockStyle('core/image', 'default');
    unregisterBlockStyle('core/image', 'rounded');
});
