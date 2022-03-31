<?php

namespace SayHello\Theme\Block;

use DOMDocument;

/**
 * Menu toggler block
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class ShtMenuToggle
{

	public function run()
	{
		add_action('render_block', [$this, 'renderBlock'], 10, 2);
	}

	public function renderBlock(string $html, array $block)
	{

		if (empty($html) || $block['blockName'] !== 'sht/menu-toggle') {
			return $html;
		}

		libxml_use_internal_errors(true);
		$document = new DOMDocument();
		$document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

		$id = $document->documentElement->childNodes[0]->childNodes[0]->getAttribute('id');

		if (empty($id)) {
			return $html;
		}

		$document->documentElement->childNodes[0]->childNodes[0]->removeAttribute('id');
		$document->documentElement->childNodes[0]->childNodes[0]->setAttribute('aria-controls', $id);

		$body = $document->saveHtml($document->getElementsByTagName('body')->item(0));
		return str_replace(['<body>', '</body>'], '', $body);
	}
}
