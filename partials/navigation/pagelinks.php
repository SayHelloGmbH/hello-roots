<?php

wp_link_pages([
	'before' => '<nav class="c-pagelinks c-nav c-nav--pagelinks"><header class="c-pagelinks__header c-nav__header c-nav__header--pagelinks"><h2>'._x('Seiten', 'Page links navigation title', 'sht').'</h2></header><ul class="c-pagelinks__entries c-menu__entries c-menu__entries--pagelinks"><li class="c-pagelinks__entry c-menu__entry c-menu__entry--pagelinks">',
	'after' => '</li></ul></nav>',
	'next_or_number' => 'number',
	'nextpagelink' => '<li class="c-pagelinks__entry c-pagelinks__entry--next c-menu__entry c-menu__entry--pagelink c-menu__entry--next">'._x('Nächste', 'Page number link', 'sht'), '</li>',
	'previouspagelink' => '<li class="c-pagelinks__entry c-pagelinks__entry--previous c-menu__entry c-menu__entry--pagelink c-menu__entry--previous">'._x('Vorige', 'Page number link', 'sht'),'</li>',
	'pagelink' => '%',
	'separator' => '</li><li class="c-pagelinks__entry c-menu__entry c-menu__entry--pagelinks">',
	'echo' => true
]);
