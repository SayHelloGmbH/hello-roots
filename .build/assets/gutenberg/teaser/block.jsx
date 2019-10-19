import "./block.scss";

const { __ } = wp.i18n;

wp.blocks.registerBlockType( 'sht/test', {
	title: __( 'Test Block' ),
	icon: 'lock',
	category: 'sht/blocks',
	edit() {
		return (
			<p className={"b-test-block"}>{__("Translated String", "sht")}</p>
		);
	},
	save() {
		return (
			<p>Not translated String (because in save function)</p>
		);
	},
} );