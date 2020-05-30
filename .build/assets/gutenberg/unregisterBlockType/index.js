import domReady from '@wordpress/dom-ready';
import { unregisterBlockType } from '@wordpress/blocks';

window.onload = function(){
	unregisterBlockType('core/media-text');
};
