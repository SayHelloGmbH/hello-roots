// externals
import assign from 'lodash.assign';
import classnames from 'classnames';
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { BlockControls, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, Button, ButtonGroup, Toolbar } from '@wordpress/components';

// icon
const icon = () => {
	return (
		<svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H18C19.11 22 20 21.11 20 20V4C20 2.9 19.11 2 18 2M18 20H6V16H18V20M18 8H6V4H18V8Z" fill="currentColor" fill-rule="nonzero"></path></g></svg>
	)
}

// enable filters for blocks
// block: defaultPadding
const enableOnBlocks = {
	'core/group': 'standard',
	'core/cover': 'standard',
}

const paddingControlOptions = [
	{
		label: __( '0', 'sht' ),
		title: __( 'Kein Innenabstand', 'sht' ),
		value: 'none',
	},
	{
		label: __( 'S', 'sht' ),
		title: __( 'Klein', 'sht' ),
		value: 'small',
	},
	{
		label: __( 'R', 'sht' ),
		title: __( 'Normal', 'sht' ),
		value: 'standard',
	},
	{
		label: __( 'M', 'sht' ),
		title: __( 'Mittelgross', 'sht' ),
		value: 'medium',
	},
	{
		label: __( 'L', 'sht' ),
		title: __( 'Gross', 'sht' ),
		value: 'large',
	},
	{
		label: __( 'XL', 'sht' ),
		title: __( 'Extragross', 'sht' ),
		value: 'xlarge',
	},
];

/**
 * Add shtPadding attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */
const addPaddingAttribute = ( settings, name ) => {
	// if block font size is enabled for this block

	let defaultSize = 'standard';

	if ( name in enableOnBlocks ) {
		defaultSize = enableOnBlocks[ name ];
	}

	// use lodash's assign to gracefully handle if attributes are undefined
	settings.attributes = assign( settings.attributes, {
		shtPadding: {
			type: 'string',
			default: defaultSize,
		},
	} );

	return settings;
}

/**
 * Add font size options to BlockEdit
 *
 * @param {object} BlockEdit Current block edit component.
 *
 * @returns {object} Modified block block edit component.
 */
const addPaddingControl = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {

		// if control is enabled for this block
		if ( !( props.name in enableOnBlocks ) ) {
			return (
				<BlockEdit { ...props } />
			);
		}

		const { shtPadding } = props.attributes;

		// remove all previous font size classes on props.attributes.className
		if ( props.attributes.className ) {
			let classes = props.attributes.className.trim().split( " " );

			Object.keys( paddingControlOptions ).map( key => {
				classes = classes.filter( function ( value, index, arr ) { return value !== 'has-block-vertical-padding--' + paddingControlOptions[ key ].value } );
			} );

			props.attributes.className = classnames( classes );
		}

		// generate each classname from paddingControlOptions
		let classNames = [];
		Object.keys( paddingControlOptions ).map( key => {
			classNames.push( {
				[ 'has-block-vertical-padding has-block-vertical-padding--' + paddingControlOptions[ key ].value ]: paddingControlOptions[ key ].value === shtPadding ? true : false
			} )
		} );

		// set the font size class names only if font size is not the blocks default font size
		if ( enableOnBlocks[ props.name ] !== shtPadding ) {
			props.attributes.className = classnames( props.attributes.className, classNames );
		}

		// return the blockedit and a panel with font size settings
		return (
			<Fragment>
				{
					<BlockControls>
						<PaddingToolbar
							value={shtPadding}
							onChange={ (size) => {
								props.setAttributes( {
									shtPadding: size,
								} )
							} }/>
					</BlockControls>
				}
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ __( 'Innenabstände', 'sht' ) }
						initialOpen={ false }
					>
						<div className="components-base-control">
							<label class="components-base-control__label">{ __( 'Vertikaler Innenabstand ändern', 'sht' ) }</label>
							<ButtonGroup>
								{Object.keys( paddingControlOptions ).map( key => {
									return (
										<Button
											isSecondary={paddingControlOptions[key].value !== shtPadding}
											isPrimary={paddingControlOptions[key].value === shtPadding}
											onClick={() => {
												props.setAttributes( {
													shtPadding: paddingControlOptions[key].value,
												})
											}}
										>{paddingControlOptions[key].label}</Button>
									)
								} )}
							</ButtonGroup>
						</div>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addPaddingControl' );

const PaddingToolbar = ( props ) => {
	const {
		value,
		onChange,
	} = props;

	function applyOrUnset( size ) {
		return () => onChange( value === size ? undefined : size );
	}

	return (
		<Toolbar
			isCollapsed={ true }
			icon={icon}
			label={ __( 'Vertikaler Innenabstand ändern', 'sht' ) }
			popoverProps={ {
				position: 'bottom right',
				isAlternate: true,
			} }
			controls={ paddingControlOptions.map( ( option ) => {
				return {
					title: option.title,
					icon: icon,
					size: option.value,
					isActive: value === option.value,
					role: 'menuitemradio',
					onClick: applyOrUnset( option.value ),
				}
			})}
		/>
	);
}

addFilter( 'blocks.registerBlockType', 'sht/attribute/block-padding', addPaddingAttribute );
addFilter( 'editor.BlockEdit', 'sht/control/block-padding', addPaddingControl );
