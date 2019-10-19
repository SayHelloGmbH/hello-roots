<?php

namespace SayHello\Theme\Package;

/**
 * Handles the replacement of ~ with &shy; throughout the Theme.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Shyify
{

	private $placeholder = '~';

	public function run()
	{
		add_filter('the_title', [$this, 'addSoftBreaks']);
		add_filter('the_content', [$this, 'addSoftBreaks']);
		add_filter('document_title_parts', [$this, 'shyifyTitleTag']);
		add_filter('wpseo_title', [$this, 'shyifyYoastTitle'], 100);
	}

	/**
	 * Remove tilde character - used for shyifying long words - from the_content and the_title
	 * @param  array $string The original string
	 * @return array             The potentially modified string
	 */
	public function addSoftBreaks($string)
	{
		return str_replace($this->placeholder, '&shy;', $string);
	}

	/**
	 * Remove tilde character - used for shyifying page or post titles - from the <TITLE> tag
	 * @param  array $titleparts The parts of the page title
	 * @return array             The potentially modified parts of the page title
	 */
	public function shyifyTitleTag($titleparts)
	{
		$titleparts['title'] = $this->addSoftBreaks($titleparts['title']);
		return $titleparts;
	}

	/**
	 * Remove tilde character - used for shyifying page or post titles - from the <title> tag of yoast
	 * @param  array $titleparts The parts of the page title
	 * @return array             The potentially modified parts of the page title
	 */
	public function shyifyYoastTitle($title)
	{
		return $this->addSoftBreaks($title);
	}
}
