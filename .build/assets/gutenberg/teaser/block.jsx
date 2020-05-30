import { __ } from '@wordpress/i18n';
import { getBlockDefaultClassName, registerBlockType } from '@wordpress/blocks';

registerBlockType( 'sht/test', {
	title: __( 'Test Block', 'sht' ),
	description: __( 'Test Block description', 'sht' ),
	icon: 'lock',
	category: 'sht/blocks',
	edit() {

		const { className } = this.props;

		return (
			<section className={className}>
				<p className={`${className}__content`}>{__('Translated String', 'sht')}</p>
			</section>
		);
	},
	save() {

		const classNameBase = getBlockDefaultClassName( 'sht/test' );

		return (
			<section className={classNameBase}>
				<p className={`${classNameBase}__content`}>Not translated String (because in save function)</p>
			</section>
		);
	},
} );
