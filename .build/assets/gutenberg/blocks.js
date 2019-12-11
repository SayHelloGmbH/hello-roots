// import "./teaser/block.jsx";

window.onload = function () {
	window.shtDisabledBlocks.forEach(block => {
		wp.blocks.unregisterBlockType(block);
	});
};

wp.domReady(() => {

	// Temporary workaround for broken preview Fn
	// Only add once per block type!
	// mhm 15.6.2019
	var el = wp.element.createElement;
	var allowColumnStyle = wp.compose.createHigherOrderComponent(function (BlockEdit) {
		return function (props) {
			var content = el(BlockEdit, props);

			if(props.name === 'core/cover' && typeof props.insertBlocksAfter === 'undefined') {
				content = el('div', {});
			}

			return el(
				wp.element.Fragment, {}, content
			);
		};
	}, 'allowColumnStyle');

	wp.hooks.addFilter('editor.BlockEdit', 'my/gutenberg', allowColumnStyle);

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