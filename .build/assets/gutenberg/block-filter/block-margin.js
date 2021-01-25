// externals
import assign from 'lodash.assign';
import classnames from 'classnames';
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { BlockControls, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, Button, ButtonGroup, Toolbar, Tooltip } from '@wordpress/components';

// icon
const icon = () => {
    return (
        <svg
            width='24'
            height='24'
            viewBox='0 0 24 24'
            xmlns='http://www.w3.org/2000/svg'
            fill-rule='evenodd'
            clip-rule='evenodd'
            stroke-linecap='round'
            stroke-linejoin='round'
            stroke-miterlimit='1.5'
        >
            <path
                stroke-width='2'
                d='M4.393 5.966h15.603v12.476H4.393z'
                transform='matrix(.89724 0 0 .80153 1.05873 2.21781)'
            />
            <path d='M9.171465 4.99992275l2.82835582-2.82835581 2.828409 2.828409-2.82815786-.0079592-2.82860695.007906zM14.828535 19.00008515l-2.82835582 2.82835581-2.828409-2.828409 2.82815786.0079592 2.82860695-.007906z' />
        </svg>
    );
};

// enable filters for blocks
const enableOnBlocks = {
    'core/heading': 'standard', // block: defaultMargin
    'core/paragraph': 'small', // block: defaultMargin
};

const controlOptions = [
    {
        label: __('0', 'sht'),
        title: __('Kein Abstand', 'sht'),
        value: 'none',
    },
    {
        label: __('S', 'sht'),
        title: __('Klein', 'sht'),
        value: 'small',
    },
    {
        label: __('R', 'sht'),
        title: __('Normal', 'sht'),
        value: 'standard',
    },
    {
        label: __('M', 'sht'),
        title: __('Mittelgross', 'sht'),
        value: 'medium',
    },
    {
        label: __('L', 'sht'),
        title: __('Gross', 'sht'),
        value: 'large',
    },
    {
        label: __('XL', 'sht'),
        title: __('Extragross', 'sht'),
        value: 'xlarge',
    },
];

/**
 * Add shtMargin attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */
const addMarginAttribute = (settings, name) => {
    // if block font size is enabled for this block

    let defaultSize = 'standard';

    if (name in enableOnBlocks) {
        defaultSize = enableOnBlocks[name];
    }

    // use lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign(settings.attributes, {
        shtMargin: {
            type: 'string',
            default: defaultSize,
        },
    });

    return settings;
};

/**
 * Add font size options to BlockEdit
 *
 * @param {object} BlockEdit Current block edit component.
 *
 * @returns {object} Modified block block edit component.
 */
const addMarginControl = createHigherOrderComponent(BlockEdit => {
    return props => {
        const { shtMargin } = props.attributes;

        // remove all previous font size classes on props.attributes.className
        if (props.attributes.className) {
            let classes = props.attributes.className.trim().split(' ');

            Object.keys(controlOptions).map(key => {
                classes = classes.filter(function (value, index, arr) {
                    return value !== 'has-block-margin--' + controlOptions[key].value;
                });
            });

            props.attributes.className = classnames(classes);
        }

        // generate each classname from controlOptions
        let classNames = [];
        Object.keys(controlOptions).map(key => {
            classNames.push({
                ['has-block-margin--' + controlOptions[key].value]:
                    controlOptions[key].value === shtMargin ? true : false,
            });
        });

        // set the font size class names only if font size is not the blocks default font size
        if (enableOnBlocks[props.name] !== shtMargin) {
            props.attributes.className = classnames(props.attributes.className, classNames);
        }

        // return the blockedit and a panel with font size settings
        return (
            <Fragment>
                {
                    <BlockControls>
                        <MarginToolbar
                            value={shtMargin}
                            onChange={size => {
                                props.setAttributes({
                                    shtMargin: size,
                                });
                            }}
                        />
                    </BlockControls>
                }
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody title={__('Aussenabstände', 'sht')} initialOpen={false}>
                        <div className='components-base-control'>
                            <label class='components-base-control__label'>
                                {__('Vertikaler Abstand ändern', 'sht')}
                            </label>
                            <ButtonGroup>
                                {Object.keys(controlOptions).map(key => {
                                    return (
                                        <Tooltip text={controlOptions[key].title}>
                                            <Button
                                                isSecondary={
                                                    controlOptions[key].value !== shtMargin
                                                }
                                                isPrimary={controlOptions[key].value === shtMargin}
                                                onClick={() => {
                                                    props.setAttributes({
                                                        shtMargin: controlOptions[key].value,
                                                    });
                                                }}
                                            >
                                                {controlOptions[key].label}
                                            </Button>
                                        </Tooltip>
                                    );
                                })}
                            </ButtonGroup>
                        </div>
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };
}, 'addMarginControl');

const MarginToolbar = props => {
    const { value, onChange } = props;

    function applyOrUnset(size) {
        return () => onChange(value === size ? undefined : size);
    }

    return (
        <Toolbar
            isCollapsed={true}
            icon={icon}
            label={__('Vertikaler Abstand ändern', 'sht')}
            popoverProps={{
                position: 'bottom right',
                isAlternate: true,
            }}
            controls={controlOptions.map(option => {
                return {
                    title: option.title,
                    icon: icon,
                    size: option.value,
                    isActive: value === option.value,
                    role: 'menuitemradio',
                    onClick: applyOrUnset(option.value),
                };
            })}
        />
    );
};

// font size filter
addFilter('blocks.registerBlockType', 'sht/attribute/block-margin', addMarginAttribute);
addFilter('editor.BlockEdit', 'sht/control/block-margin', addMarginControl);
