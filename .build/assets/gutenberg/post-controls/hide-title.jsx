import { _x } from '@wordpress/i18n';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl } from '@wordpress/components';
import { compose } from '@wordpress/compose';
import { withDispatch, withSelect } from '@wordpress/data';
import { registerPlugin } from '@wordpress/plugins';

let HideTitleControl = ( { hideTitle, postType, onUpdateHideTitle } ) => {
	return (
		<ToggleControl
			label={ _x('Beitragstitel verstecken', 'ToggleControl label', 'sha') }
			help={ hideTitle ? _x('Der Beitragstitel ist auf der öffentlichen Ansicht ausgeblendet. Es für die Suchmaschinenoptimierung ratsam, eine Überschrift mit der Ebene H1 in den Inhalt einzufügen.', 'Warning text', 'sha') : '' }
			checked={ hideTitle }
			onChange={ hideTitle => onUpdateHideTitle( hideTitle ) }
		/>
	);
};

HideTitleControl = compose( [
	withSelect( ( select ) => {
		return {
			hideTitle: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ 'hide_title' ],
			postType: select( 'core/editor' ).getCurrentPostType(),
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
