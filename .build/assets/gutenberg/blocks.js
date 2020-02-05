import "./teaser/block.jsx";

window.onload = function () {
	window.shtDisabledBlocks.forEach(block => {
		wp.blocks.unregisterBlockType(block);
	});
};

wp.domReady(() => {
	wp.blocks.registerBlockStyle('core/cover', {
		name: 'aspect-21',
		label: '2:1'
	});
	wp.blocks.registerBlockStyle('core/cover', {
		name: 'aspect-31',
		label: '3:1'
	});
	wp.blocks.registerBlockStyle('core/cover', {
		name: 'aspect-41',
		label: '4:1'
	});
	wp.blocks.registerBlockStyle('core/cover', {
		name: 'aspect-169',
		label: '16:9'
	});
	wp.blocks.registerBlockStyle('core/cover', {
		name: 'full-height',
		label: 'Full height'
	});
});