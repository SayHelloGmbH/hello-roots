import { unregisterBlockVariation } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

domReady(() => {
    unregisterBlockVariation('core/group', 'group-stack');
});
