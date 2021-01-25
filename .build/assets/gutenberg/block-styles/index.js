import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

domReady(() => {
    registerBlockStyle('core/heading', {
        name: 'small-text',
        label: 'Klein',
    });
    registerBlockStyle('core/heading', {
        name: 'large-text',
        label: 'Gross',
    });
    registerBlockStyle('core/heading', {
        name: 'xlarge-text',
        label: 'Extra-gross',
    });
});
