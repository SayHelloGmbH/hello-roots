// externals
import assign from 'lodash.assign';
import classnames from 'classnames';
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls, BlockControls } from '@wordpress/block-editor';
import { PanelBody, Button, ButtonGroup, Toolbar } from '@wordpress/components';

// icon
const icon = () => {
	return (
		<svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M18.5,5.37867966 L20.6213203,7.5 L19.9142136,8.20710678 L18.9996406,7.29267966 L18.9996406,16.3276797 L19.9142139,15.4142136 L20.6213207,16.1213203 L18.5000003,18.2426407 L16.37868,16.1213203 L17.0857868,15.4142136 L17.9996406,16.3276797 L17.9996406,7.29267966 L17.0857864,8.20710678 L16.3786797,7.5 L18.5,5.37867966 Z M10.6865234,5.76464844 L15.0195312,18 L12.2470703,18 L11.4584961,15.4848633 L6.95117188,15.4848633 L6.10449219,18 L3.43164062,18 L7.79785156,5.76464844 L10.6865234,5.76464844 Z M9.21728516,8.56201172 L7.64013672,13.3764648 L10.7446289,13.3764648 L9.21728516,8.56201172 Z" fill="currentColor" fill-rule="nonzero"></path></g></svg>
	)
}

// enable filters for blocks
const enableFontSizeOnBlocks = {
	'core/heading': 'regular', // block: defaultFontSize
	'core/paragraph': 'regular' // block: defaultFontSize
}

const fontSizeControlOptions = [ {
		label: __( 'S', 'sht' ),
		title: __( 'Klein', 'sht' ),
		value: 'small',
	},
	{
		label: __( 'R', 'sht' ),
		title: __( 'Normal', 'sht' ),
		value: 'regular',
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
		title: __( 'Extra gross', 'sht' ),
		value: 'xlarge',
	},
];

/**
 * Add shtFontSize attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */
const addFontSizeAttribute = ( settings, name ) => {
	// if block font size is enabled for this block
	if ( !( name in enableFontSizeOnBlocks ) ) {
		return settings;
	}

	// use lodash's assign to gracefully handle if attributes are undefined
	settings.attributes = assign( settings.attributes, {
		shtFontSize: {
			type: 'string',
			default: enableFontSizeOnBlocks[ name ],
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
const addFontSizeControl = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		// if block font size is enabled for this block
		if ( !( props.name in enableFontSizeOnBlocks ) ) {
			return (
				<BlockEdit { ...props } />
			);
		}

		const { shtFontSize } = props.attributes;

		// remove all previous font size classes on props.attributes.className
		if ( props.attributes.className ) {
			let classes = props.attributes.className.trim().split( " " );

			Object.keys( fontSizeControlOptions ).map( key => {
				classes = classes.filter( function ( value, index, arr ) { return value !== 'has-font-size-' + fontSizeControlOptions[ key ].value } );
			} );

			props.attributes.className = classnames( classes );
		}

		// generate each classname from fontSizeControlOptions
		let classNames = [];
		Object.keys( fontSizeControlOptions ).map( key => {
			classNames.push( {
				[ 'has-font-size-' + fontSizeControlOptions[ key ].value ]: fontSizeControlOptions[ key ].value === shtFontSize ? true : false
			} )
		} );

		// set the font size class names only if font size is not the blocks default font size
		if ( enableFontSizeOnBlocks[ props.name ] !== shtFontSize ) {
			props.attributes.className = classnames( props.attributes.className, classNames );
		}

		// return the blockedit and a panel with font size settings
		return (
			<Fragment>
				{
					<BlockControls>
						<FontSizeToolbar
							value={shtFontSize}
							onChange={ (size) => {
								props.setAttributes( {
									shtFontSize: size,
								} )
							} }/>
					</BlockControls>
				}
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ __( 'Schriftgrösse ändern', 'sht' ) }
						initialOpen={ false }
					>
						<div className="components-base-control">
							<label class="components-base-control__label">{ __( 'Schriftgrösse ändern', 'sht' ) }</label>
							<ButtonGroup>
								{Object.keys( fontSizeControlOptions ).map( key => {
									return (
										<Button
											isSecondary={fontSizeControlOptions[key].value !== shtFontSize}
											isPrimary={fontSizeControlOptions[key].value === shtFontSize}
											isPressed={fontSizeControlOptions[key].value === shtFontSize}
											onClick={() => {
												props.setAttributes( {
													shtFontSize: fontSizeControlOptions[key].value,
												} )
											}}
										>{fontSizeControlOptions[key].label}</Button>
									)
								} )}
							</ButtonGroup>
						</div>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addFontSizeControl' );

const FontSizeToolbar = ( props ) => {
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
			label={ __( 'Schriftgrösse ändern', 'sht' ) }
			popoverProps={ {
				position: 'bottom right',
				isAlternate: true,
			} }
			controls={ fontSizeControlOptions.map( ( option ) => {
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

// font size filter
addFilter( 'blocks.registerBlockType', 'sht/attribute/font-size', addFontSizeAttribute );
addFilter( 'editor.BlockEdit', 'sht/control/font-size', addFontSizeControl );
