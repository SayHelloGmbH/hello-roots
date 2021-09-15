<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with menus and site navigation
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class Navigation
{

	private $menus;

	public function __construct()
	{
		$this->menus = [
			'primary' => _x('Primary', 'Menu navigation label', 'sha'),
			'mobile' => _x('Mobile', 'Menu navigation label', 'sha'),
		];
	}

	public function run()
	{
		add_filter('wp_nav_menu_args', [$this, 'navMenuArgs'], 1, 1);
		add_filter('nav_menu_css_class', [$this, 'menuItemClasses'], 10, 4);
		add_filter('nav_menu_link_attributes', [$this, 'menuLinkAttributes']);
		add_filter('paginate_links_output', [$this, 'paginateLinks']);

		if (count($this->menus)) {
			add_action('after_setup_theme', [$this, 'themeSupport']);
		}
	}

	public function themeSupport()
	{
		add_theme_support('menu');
		register_nav_menus($this->menus);
	}

	public function navMenuArgs($args)
	{
		$args['fallback_cb'] = false;
		$args['menu_class'] = 'c-menu__entries c-menu__entries--' . $args['theme_location'];
		return $args;
	}

	public function menuItemClasses($classes, $item, $args, $depth)
	{
		$classes[] = 'c-menu__entry c-menu__entry--depth-' . $depth . ' c-menu__entry--' . $args->theme_location;
		if ($item->current) {
			$classes[] = 'c-menu__entry--current';
		}
		if ($item->current_item_ancestor) {
			$classes[] = 'c-menu__entry--current_item_ancestor';
		}
		if ($item->current_item_parent) {
			$classes[] = 'c-menu__entry--current_item_parent';
		}
		return $classes;
	}

	public function menuLinkAttributes($atts)
	{
		if (!isset($atts['class'])) {
			$atts['class'] = '';
		}
		$atts['class'] = (!empty($atts['class']) ? ' ' : '') . 'c-menu__entrylink';
		return $atts;
	}

	/**
	 * Removes next/previous links and replaces them
	 * with SVG arrows. Also adds links to first/last pages.
	 *
	 * mark@sayhello.ch 13.8.2021
	 *
	 * @param string $html
	 * @return string
	 */
	public function paginateLinks($html)
	{
		if (empty($html)) {
			return $html;
		}

		libxml_use_internal_errors(true);

		$domDocument = new DOMDocument();
		$domDocument->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

		$xpath = new DOMXpath($domDocument);

		global $wp_query;
		$last = intval($wp_query->max_num_pages);
		$first_url = esc_url(get_pagenum_link(1));
		$last_url = esc_url(get_pagenum_link($last));
		$svg_firstlast = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5.59,7.41,10.18,12,5.59,16.59,7,18l6-6L7,6ZM16,6h2V18H16Z" /></svg>';
		$svg_nextprev = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10,6,8.59,7.41,13.17,12,8.59,16.59,10,18l6-6Z"/></svg>';

		$comment = $domDocument->createComment('Custom next/prev/first/last SVG links added by Navigation Package in the Theme');
		$first_element = $domDocument->getElementsByTagName('a')[0];
		$first_element->parentNode->insertBefore($comment, $first_element);

		foreach ($xpath->query('//a[contains(@class, "prev")]') as $link) {

			// Add first page link
			$link_first = $domDocument->createElement('a');
			$link_first->setAttribute('class', 'page-numbers first');
			$link_first->setAttribute('href', $first_url);
			$link_first->setAttribute('aria-label', _x('Erste Seite', 'Pagination link text', 'sht'));
			$this->appendHTML($link_first, $svg_firstlast);
			$link->parentNode->insertBefore($link_first, $link);

			// Add previous page link with SVG
			$link_prev = $domDocument->createElement('a');
			$link_prev->setAttribute('class', 'page-numbers prev');
			$link_prev->setAttribute('href', $last_url);
			$link_prev->setAttribute('aria-label', _x('Zurück', 'Pagination link text', 'sht'));
			$this->appendHTML($link_prev, $svg_nextprev);
			$link->parentNode->insertBefore($link_prev, $link_first->nextSibling);

			// Remove original previous page link
			$link->parentNode->removeChild($link);
		}

		foreach ($xpath->query('//a[contains(@class, "next")]') as $link) {

			// Add last page link
			$link_last = $domDocument->createElement('a');
			$link_last->setAttribute('class', 'page-numbers last');
			$link_last->setAttribute('href', $last_url);
			$link_last->setAttribute('aria-label', _x('Letzte Seite', 'Pagination link text', 'sht'));
			$this->appendHTML($link_last, $svg_firstlast);
			$link->parentNode->insertBefore($link_last, $link->nextSibling);

			// Add next page link with SVG
			$link_next = $domDocument->createElement('a');
			$link_next->setAttribute('class', 'page-numbers next');
			$link_next->setAttribute('href', $last_url);
			$link_next->setAttribute('aria-label', _x('Weiter', 'Pagination link text', 'sht'));
			$this->appendHTML($link_next, $svg_nextprev);
			$link_last->parentNode->insertBefore($link_next, $link_last);

			// Remove original next page link
			$link->parentNode->removeChild($link);
		}

		$body = $domDocument->saveHtml($domDocument->getElementsByTagName('body')->item(0));
		return str_replace(['<body>', '</body>'], '', $body);
	}

	/**
	 * Helper function to allow easy adding an
	 * HTML string to the parent as a child node.
	 *
	 * @param DOMNode $parent
	 * @param string $source
	 * @return void
	 */
	private function appendHTML(DOMNode $parent, string $source)
	{
		$tmpDoc = new DOMDocument();
		$tmpDoc->loadHTML($source);
		foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
			$node = $parent->ownerDocument->importNode($node, true);
			$parent->appendChild($node);
		}
	}
}
