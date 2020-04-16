import { c, color, theme, is_mobile } from './modules/settings.js';
import '@sayhellogmbh/maybe-set-link-target';

(function ($) {
	$(function () {

		console.log("%cDesigned by", "font-style: italic; font-size: 12px;");
		console.log("%csome cool agency", "font-weight: bold; color: #000; font-size: 16px;");
		console.log("%chttps://sayhello.ch", "color: #000; font-size: 12px;");
		console.log('');

		console.log("%cDeveloped by", "font-style: italic; font-size: 12px;");
		console.log("%cSay Hello GmbH", "font-weight: bold; color: #000; font-size: 16px;");
		console.log("%chttps://sayhello.ch", "color: #000; font-size: 12px;");
		console.log('');

		$('a').maybeSetLinkTarget();

	});
})(jQuery);
