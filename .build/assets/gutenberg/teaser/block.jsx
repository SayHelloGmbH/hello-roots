import "./block.scss";

const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;

registerBlockType('sht/test', {
	title: __('Text'),
	icon: 'lock',
	category: 'sht/blocks',
	edit() {
		return (
			<p>Static block example built with JSX.</p>
		);
	},
	save() {
		return (
			<p>Static block example built with JSX.</p>
		);
	},
});
