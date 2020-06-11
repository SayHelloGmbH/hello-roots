import { _x } from '@wordpress/i18n';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl } from '@wordpress/components';
import { compose } from '@wordpress/compose';
import { withDispatch, withSelect } from '@wordpress/data';
import { registerPlugin } from '@wordpress/plugins';

const validPostTypes = [
	'page',
	'post',
];

const isValidPostType = function ( name ) {
	return validPostTypes.includes( name );
};

let HideTitleControl = ( { hide_title, post_type, onUpdateHideTitle } ) => {
	if(!isValidPostType(post_type)){
		console.error(`Add support for hide_title to the post type "${post_type}" using "register_post_meta" in PHP, or the meta value won't be saved! You also need to amend the allowed post type array in isValidPostType (hide-title.jsx).`);
	}

	return (
		<ToggleControl
			label={ _x('Beitragstitel verstecken', 'ToggleControl label', 'sha') }
			help={ hide_title ? _x('Der Beitragstitel ist auf der öffentlichen Ansicht ausgeblendet. Es für die Suchmaschinenoptimierung ratsam, eine Überschrift mit der Ebene H1 in den Inhalt einzufügen.', 'Warning text', 'sha') : '' }
			checked={ hide_title }
			onChange={ hide_title => onUpdateHideTitle( hide_title ) }
		/>
	);
};

HideTitleControl = compose( [
	withSelect( ( select ) => {
		return {
			hide_title: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ 'hide_title' ],
			post_type: select( 'core/editor' ).getCurrentPostType(),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			onUpdateHideTitle: ( metaValue ) => {
				dispatch( 'core/editor' ).editPost(
					{ meta: { hide_title: metaValue } }
				);
			}
		}
	} ),
] )( HideTitleControl );

const SHTPageControls = () => (
	<PluginDocumentSettingPanel
			title={_x('Seitenoptionen', 'Editor sidebar panel title', 'sht')}
			initialOpen={true}
			icon={'invalid-name-no-icon'}
			>
			<HideTitleControl />
		</PluginDocumentSettingPanel>
);

registerPlugin( 'sht-page-controls', { render: SHTPageControls } );
