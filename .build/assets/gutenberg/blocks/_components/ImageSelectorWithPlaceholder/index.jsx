/**
 * Image selector for Say Hello components
 * https://github.com/SayHelloGmbH/Gutenberg/tree/master/components/ImageSelectorWithPlaceholder
 * mark@sayhello.ch 12.8.2020
 */

import { Button, Toolbar, IconButton, Spinner } from '@wordpress/components';
import { Component, Fragment } from '@wordpress/element';
import { MediaPlaceholder, BlockControls, MediaUpload, MediaReplaceFlow } from '@wordpress/block-editor';
import { _x } from '@wordpress/i18n';

import { getLazySrcs } from '../lazyimage.jsx';

export default class ImageSelectorWithPlaceholder extends Component {

	constructor( props ) {
		super( ...arguments );
		this.props = props;
		this.state = {is_uploading: false};

		const {
			attributes,
			setAttributes,
			imageAttribute,
			imageExternalURLAttribute,
			imageFormat,
			allowURL,
			accept,
			allowedTypes,
			labels
		} = this.props;

		this.accept_types = accept || 'image/*';
		this.allowed_types = allowedTypes || [ 'image' ];
		this.allow_url = !!allowURL;
		this.image_attribute_key = imageAttribute || 'image';
		this.image_format = imageFormat || 'full';
		this.url_attribute_key = imageExternalURLAttribute || 'imageExternalURL';
		this.labels_object = labels || {};

		this.imageExternalURL_attribute = attributes[ this.url_attribute_key ];

		// Callback when an image is selected from a external URL.
		// If this isn't defined, then the button to add an image
		// via URL won't be displayed.

		this.onSelectURL = null;

		if(allowURL){
			this.onSelectURL = url => {
				this.props.setAttributes({
					[this.image_attribute_key]: {id: false},
					[this.url_attribute_key]: url
				});
				this.setState({is_uploading: false});
			};
		}

		if(this.onSelectURL){
			this.onSelectURL = this.onSelectURL.bind(this);
		}

		this.onSelect = this.onSelect.bind(this);
		this.onPreUpload = this.onPreUpload.bind(this);
		this.clearAttributeValues = this.clearAttributeValues.bind(this);
	}

	// Callback when an image is selected from
	// the Media Library. This can be called multiple
	// times for one upload; once each time the
	// state of the upload process (blob, complete)
	// changes.

	onSelect(image){
		if(!image.id && image.url){
			if(image.url.indexOf('blob:') === 0){
				this.props.setAttributes({
					[this.url_attribute_key]: ''
				});
				return;
			}
			this.props.setAttributes({
				[this.url_attribute_key]: image.url
			});
			this.setState({is_uploading: false});
			return;
		}
		if(!!image.id){
			let setAttributes = this.props.setAttributes;
			getLazySrcs(image.id, this.image_format).then(image => {
				setAttributes({[this.image_attribute_key]: image});
				this.setState({is_uploading: false});
			});
		}
	};

	onPreUpload(files){
		this.clearAttributeValues();
		this.setState({is_uploading: true});
	};

	clearAttributeValues(){
		this.props.setAttributes({
			[this.url_attribute_key]: '',
			[this.image_attribute_key]: {id: false}
		});
	};

	render() {

		const image = this.props.attributes[this.image_attribute_key];
		const imageExternalURL = this.props.attributes[this.url_attribute_key];

		return (

			<Fragment>
				{ (!!image.id || !!imageExternalURL) && !this.state.is_uploading &&
					<BlockControls>
						<Toolbar>
							<MediaReplaceFlow
								name={_x('Bild ersetzen', 'MediaReplaceFlow label', 'sha')}
								mediaId={image.id}
								mediaURL={this.imageExternalURL_attribute}
								accept={this.accept_types}
								allowedTypes={this.allowed_types}
								onFilesUpload={this.onPreUpload}
								onSelect={this.onSelect}
								onSelectURL={this.onSelectURL}
							/>
						</Toolbar>
					</BlockControls>
				}
				{
					!!this.state.is_uploading &&
					<Fragment>
						<p>{ _x('Datei wird hochgeladen... bitte warten Sie...', 'Upload message', 'sha')}</p>
						<Spinner />
					</Fragment>
				}
				{ !image.id && !imageExternalURL && !this.state.is_uploading &&
					<div className="c-mediaselector c-mediaselector--image components-base-control components-lazy-image-selector">
						<MediaPlaceholder
							icon="format-image"
							labels={this.labels_object}
							multiple={false}
							onFilesPreUpload={this.onPreUpload}
							onSelect={this.onSelect}
							onSelectURL={this.onSelectURL}
							accept={this.accept_types}
							allowedTypes={this.allowed_types}
						/>
					</div>
				}
			</Fragment>
		);
	}
}
