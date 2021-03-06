/**
 * Disable specific blocks within the Gutenberg Editor
 * Runs a check against all currently registered blocks
 * to ensure that a JavaScript error isn't provoked by
 * trying to unregister a block which isn't registered.
 *
 * mark@sayhello.ch 18.11.2020
 */

import { getBlockTypes, unregisterBlockType } from '@wordpress/blocks';

// The domReady handler from Gutenberg doesn't currently
// work correctly so we're using a regular event listener.
document.addEventListener('DOMContentLoaded', () => {
    let activeBlocks = [];

    getBlockTypes().forEach(function (blockType) {
        activeBlocks.push(blockType.name);
    });

    // These Blocks will be unregistered.
    // Instagram is here by default because it
    // dropped oEmbed support in 2020
    ['core-embed/instagram'].forEach(block => {
        if (activeBlocks.includes(block)) {
            unregisterBlockType(block);
            //console.log(`block ${block} unregistered by Theme`);
        }
    });
});
