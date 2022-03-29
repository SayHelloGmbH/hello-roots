<?php

namespace SayHello\Theme\Block;

use DOMDocument;

/**
 * Template Part block
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class TemplatePart
{

	public function run()
	{
		add_action('render_block', [$this, 'renderBlock'], 10, 2);
	}

	/**
	 * This removes the wrapping DIV from all template part blocks
	 *
	 * @param string $html
	 * @param array $block
	 * @return string
	 */
	public function renderBlock(string $html, array $block)
	{

		if (empty($html) || $block['blockName'] !== 'core/template-part') {
			return $html;
		}

		libxml_use_internal_errors(true);

		$document = new DOMDocument();
		$document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		$wrapper = $document->documentElement->childNodes[0]->childNodes[0];

		// Make sure that the wrapper contains the standard template part class name
		if (strpos($wrapper->getAttribute('class'), 'wp-block-template-part') === FALSE) {
			return $html;
		}

		$document_out = new DOMDocument();

		foreach ($wrapper->childNodes as $child) {
			$document_out->appendChild($document_out->importNode($child->cloneNode(true), true));
		}

		return $document_out->saveHtml();
	}
}
