import "./teaser/block.jsx";

window.shtDisabledBlocks.forEach(block => {
	wp.blocks.unregisterBlockType(block);
});
