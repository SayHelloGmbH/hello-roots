import domReady from '@wordpress/dom-ready';
import { unregisterBlockType } from '@wordpress/blocks';

domReady(() => {
	if(window.shtDisabledBlocks && window.shtDisabledBlocks.length){
		window.shtDisabledBlocks.forEach(block => {
			unregisterBlockType(block);
		});
	}
});
