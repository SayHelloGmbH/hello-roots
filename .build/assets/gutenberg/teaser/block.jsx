import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'sht/test', {
	title: __( 'Test Block', 'sht' ),
	description: __( 'Test Block description', 'sht' ),
	icon: 'lock',
	category: 'sht/blocks',
	edit() {
		return (
			<p className={"b-test-block"}>{__('Translated String', 'sht')}</p>
		);
	},
	save() {
		return (
			<p>Not translated String (because in save function)</p>
		);
	},
} );