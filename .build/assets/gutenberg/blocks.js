// import "./teaser/block.jsx";

window.onload = function () {
	window.shtDisabledBlocks.forEach(block => {
		wp.blocks.unregisterBlockType(block);
	});
};