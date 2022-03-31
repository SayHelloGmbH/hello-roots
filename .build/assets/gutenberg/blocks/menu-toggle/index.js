import { getBlockDefaultClassName, registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { _x } from '@wordpress/i18n';
import { button as icon } from '@wordpress/icons';

const blockName = 'sht/menu-toggle',
    classNameBase = getBlockDefaultClassName(blockName);

registerBlockType(blockName, {
    apiVersion: 2,
    title: _x('Menü-Toggle-Schalter', 'Block title', 'sha'),
    icon,
    category: 'sht/blocks',
    keywords: ['navigation', 'toggle'],
    supports: {
        anchor: true,
        align: false,
        html: false,
    },
    edit: () => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <span className={`${classNameBase}__line ${classNameBase}__line--1`} />
                <span className={`${classNameBase}__line ${classNameBase}__line--2`} />
                <span className={`${classNameBase}__line ${classNameBase}__line--3`} />
            </div>
        );
    },
    save: ({ attributes }) => {
        const extraProps = {
            'aria-expanded': false,
            'data-root-style': 'is--mobilemenu--open',
        };

        if (!!attributes.anchor) {
            extraProps['aria-controls'] = attributes.anchor;
        }

        const blockProps = useBlockProps.save(extraProps);

        return (
            <button {...blockProps}>
                <span className={`${classNameBase}__line ${classNameBase}__line--1`} />
                <span className={`${classNameBase}__line ${classNameBase}__line--2`} />
                <span className={`${classNameBase}__line ${classNameBase}__line--3`} />
            </button>
        );
    },
});
