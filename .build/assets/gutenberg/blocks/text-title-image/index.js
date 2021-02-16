/**
 * Block basis containing a title field, a text field and an image
 * which uses the selector technique as used by WordPress Core
 * Blocks in August 2020. (MediaPlaceholder when no image selected and
 * a “replace” button in the toolbar when an image is selected.)
 *
 * https://github.com/SayHelloGmbH/Gutenberg/tree/master/components/ImageSelectorWithPlaceholder
 *
 * The attribute “imageExternalURL” is only used for the preview (see
 * “example” below). The function which allows a user to select an
 * external URL from the MediaPlaceholder is deactivated.
 *
 * mark@sayhello.ch, November 2020
 */

// WordPress
import { RichText } from '@wordpress/block-editor';
import { getBlockDefaultClassName, registerBlockType } from '@wordpress/blocks';
import { Component } from '@wordpress/element';
import { _x } from '@wordpress/i18n';
import { sayhello as icon } from '../../icons';

// Say Hello
import ImageSelectorWithPlaceholder from '../_components/ImageSelectorWithPlaceholder';
import { LazyImage } from '../_components/LazyImage';

const blockName = 'sht/contact-info';
const classNameBase = getBlockDefaultClassName(blockName);

registerBlockType(blockName, {
    title: _x('Titel, Text, Bild', 'Block title', 'sha'),
    description: _x('Block mit einem Titel, einen Text und einem Bild.', 'Block title', 'sha'),
    icon,
    category: 'design',
    supports: {
        align: false,
        html: false,
    },
    example: {
        attributes: {
            title:
                'Lorem ipsum dolor<br>Sit amet consectetur<br>Adipisicing elit sed<br>Do eiusmod tempor<br>Incididunt ut labore',
            text:
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            imageExternalURL: 'https://sayhello.ch/gutenberg-demo-image-do-not-delete.jpg',
        },
    },
    attributes: {
        imageExternalURL: {
            source: 'attribute',
            selector: `img.${classNameBase}__imagefromurl`,
            attribute: 'src',
        },
        image: {
            type: 'Object',
            default: {
                id: false,
            },
        },
        text: {
            type: 'string',
        },
        title: {
            type: 'string',
        },
    },
    edit: class extends Component {
        constructor(props) {
            super(...arguments);
            this.props = props;
        }

        render() {
            const classNameBase = getBlockDefaultClassName(blockName);

            const { attributes, className, setAttributes } = this.props;

            const { imageExternalURL, image, text, title } = attributes;

            return [
                <div className={className}>
                    <div className={`${classNameBase}__inner`}>
                        <div className={`${classNameBase}__figurewrap`}>
                            <ImageSelectorWithPlaceholder
                                attributes={attributes}
                                setAttributes={setAttributes}
                                allowedTypes={['image/jpeg']}
                                accept={'image/jpeg'}
                                allowURL={false}
                                labels={{
                                    title: _x('Bild auswählen', 'MediaPlaceholder title', 'sha'),
                                    instructions: _x(
                                        'Bitte wählen Sie ein Bild aus. (JPG.)',
                                        'MediaPlaceholder instructions',
                                        'sha'
                                    ),
                                }}
                            />
                            {!!image.id && (
                                <LazyImage
                                    className={`${classNameBase}__figure`}
                                    image={image}
                                    background={false}
                                    admin={true}
                                />
                            )}
                            {!!imageExternalURL && !image.id && (
                                <figure className={`${classNameBase}__figure`}>
                                    <img
                                        className={`${classNameBase}__imagefromurl`}
                                        src={imageExternalURL}
                                        alt=''
                                    />
                                </figure>
                            )}
                        </div>
                        <div className={`${classNameBase}__contentwrap`}>
                            <RichText
                                tagName='p'
                                placeholder={_x(
                                    'Schreiben Sie eine Überschrift…',
                                    'Field placeholder',
                                    'sha'
                                )}
                                className={`${classNameBase}__title`}
                                value={title}
                                allowedFormats={[]}
                                multiline={false}
                                keepPlaceholderOnFocus={true}
                                onChange={value => {
                                    setAttributes({ title: value });
                                }}
                            />
                            <RichText
                                tagName='p'
                                placeholder={_x(
                                    'Schreiben Sie einen Text…',
                                    'Field placeholder',
                                    'sha'
                                )}
                                className={`${classNameBase}__text`}
                                value={text}
                                allowedFormats={[]}
                                multiline={false}
                                keepPlaceholderOnFocus={true}
                                onChange={value => {
                                    setAttributes({ text: value });
                                }}
                            />
                        </div>
                    </div>
                </div>,
            ];
        }
    },
    save({ attributes, className }) {
        const classNameBase = getBlockDefaultClassName(blockName);

        const { imageExternalURL, image, text, title } = attributes;

        return (
            <div className={className}>
                <div className={`${classNameBase}__figurewrap`}>
                    {!!image.id && (
                        <LazyImage
                            className={`${classNameBase}__figure`}
                            image={image}
                            background={false}
                            admin={false}
                        />
                    )}
                    {!!imageExternalURL && !image.id && (
                        <figure className={`${classNameBase}__figure`}>
                            <img
                                className={`${classNameBase}__imagefromurl`}
                                src={imageExternalURL}
                                alt={text}
                            />
                        </figure>
                    )}
                </div>
                <div className={`${classNameBase}__contentwrap`}>
                    <RichText.Content
                        className={`${classNameBase}__title`}
                        value={title}
                        tagName='p'
                    />
                    <RichText.Content
                        className={`${classNameBase}__text`}
                        value={text}
                        tagName='p'
                    />
                </div>
            </div>
        );
    },
});
