import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { _x } from '@wordpress/i18n';
import { archiveTitle as icon } from '@wordpress/icons';

const blockName = 'sht/archive-title-search';

registerBlockType(blockName, {
    apiVersion: 2,
    title: _x('Archive Title (Search)', 'Block title', 'sha'),
    icon,
    category: 'sht/blocks',
    keywords: [
        _x('Bilder', 'Block keyword', 'sha'),
        'image',
        'gallery',
        _x('Impressionen', 'Block keyword', 'sha'),
    ],
    supports: {
        align: ['wide', 'full'],
        html: false,
    },
    edit: () => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <ServerSideRender block={blockName} />
            </div>
        );
    },
    save() {
        return null;
    },
});
