// import domReady from '@wordpress/dom-ready';
import { unregisterBlockStyle } from '@wordpress/blocks';

// domReady(() => {
//     registerBlockStyle('core/heading', {
//         name: 'special',
//         label: 'Special',
//     });
// });

window.addEventListener('load', () => {
    unregisterBlockStyle('core/image', 'default');
    unregisterBlockStyle('core/image', 'rounded');
});
