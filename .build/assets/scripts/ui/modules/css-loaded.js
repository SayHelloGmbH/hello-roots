(function($) {

	const elementId = 'css-loaded';
	const eventKey = 'cssLoaded';
	exports.event = eventKey;

	$(function() {

		$('body').append(`<div id="${elementId}" style="display: none;"></div>`);
		const $e = $(`#${elementId}`);

		const cssLoadedInterval = window.setInterval(function() {

			if ($e.is(":visible")) {

				$(document).trigger(eventKey);
				$e.remove();
				clearInterval(cssLoadedInterval);
			}
		}, 100);
	});
})(jQuery);
