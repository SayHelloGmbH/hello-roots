/**
 * Add visibility toggle to Core Blocks, so that Blocks can be hidden per breakpoint
 * Thanks Jeffrey Carandang
 * https://jeffreycarandang.com/extending-gutenberg-core-blocks-with-custom-attributes-and-controls/
 *
 * Current version mark@sayhello.ch 16.3.2022
 */

import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { Fragment } from '@wordpress/element';
import { createHigherOrderComponent } from '@wordpress/compose';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

import classnames from 'classnames';

/**
 * Restrict to specific blocks
 */
const allowedBlocks = ['core/group', 'sht/menu-toggler'];

/**
 * Add custom attributes for mobile visibility.
 */
addFilter('blocks.registerBlockType', 'sht/custom-attributes', settings => {
    if (!allowedBlocks.includes(settings.name)) {
        return settings;
    }

    return lodash.assign({}, settings, {
        attributes: lodash.assign({}, settings.attributes, {
            hiddenForMobile: {
                type: 'boolean',
                default: false,
            },
            hiddenForTablet: {
                type: 'boolean',
                default: false,
            },
            hiddenForDesktop: {
                type: 'boolean',
                default: false,
            },
        }),
    });
});

/**
 * Add visibility controls as block panel.
 */
addFilter(
    'editor.BlockEdit',
    'sht/custom-advanced-control',
    createHigherOrderComponent(BlockEdit => {
        return props => {
            const { name, attributes, setAttributes, isSelected } = props;

            const { hiddenForMobile, hiddenForTablet, hiddenForDesktop } = attributes;

            if (!isSelected || !allowedBlocks.includes(name)) {
                return <BlockEdit {...props} />;
            }
            return (
                <Fragment>
                    <BlockEdit {...props} />
                    <InspectorControls>
                        <PanelBody title={__('Sichtbarkeit', 'sht')} initialOpen={true}>
                            <ToggleControl
                                label={__('Auf Mobilgeräte verstecken')}
                                checked={!!hiddenForMobile}
                                onChange={() =>
                                    setAttributes({ hiddenForMobile: !hiddenForMobile })
                                }
                                help={
                                    !!hiddenForMobile
                                        ? __('Dieser Block ist versteckt auf Mobilgeräte.', 'sha')
                                        : ''
                                }
                            />
                            <ToggleControl
                                label={__('Auf Tabletts verstecken')}
                                checked={!!hiddenForTablet}
                                onChange={() =>
                                    setAttributes({ hiddenForTablet: !hiddenForTablet })
                                }
                                help={
                                    !!hiddenForTablet
                                        ? __('Dieser Block ist versteckt auf Tabletts.', 'sha')
                                        : ''
                                }
                            />
                            <ToggleControl
                                label={__('Auf Desktopcomputer verstecken')}
                                checked={!!hiddenForDesktop}
                                onChange={() =>
                                    setAttributes({ hiddenForDesktop: !hiddenForDesktop })
                                }
                                help={
                                    !!hiddenForDesktop
                                        ? __(
                                              'Dieser Block ist versteckt auf Desktopcomputer.',
                                              'sha'
                                          )
                                        : ''
                                }
                            />
                        </PanelBody>
                    </InspectorControls>
                </Fragment>
            );
        };
    })
);

/**
 * Add custom element class in save context.
 */
addFilter(
    'blocks.getSaveContent.extraProps',
    'sht/applyExtraClass',
    (extraProps, blockType, attributes) => {
        const { hiddenForMobile, hiddenForTablet, hiddenForDesktop } = attributes;

        if (!allowedBlocks.includes(blockType.name)) {
            return extraProps;
        }

        if (!!hiddenForMobile) {
            extraProps.className = classnames(extraProps.className, 'is-hidden-for--mobile');
        }

        if (!!hiddenForTablet) {
            extraProps.className = classnames(extraProps.className, 'is-hidden-for--tablet');
        }

        if (!!hiddenForDesktop) {
            extraProps.className = classnames(extraProps.className, 'is-hidden-for--desktop');
        }

        return extraProps;
    }
);
