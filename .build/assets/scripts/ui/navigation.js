(function ($) {
	$(function () {

		const $toggler = $('.js-navtoggler');

		$toggler.on('click', function () {
			const $e = $(this);
			const navID = $e.attr('aria-controls');
			const $nav = $(`#${navID}`);
			if (!$nav.length) {
				console.log(`navigation #${navID} not found`);
				return;
			}

			const open = ($e.attr('aria-expanded') === 'true');

			if (open) {
				$e.attr('aria-expanded', 'false');
				$nav.slideUp();
			} else {
				$e.attr('aria-expanded', 'true');
				$nav.slideDown();
			}
		});
	});
})(jQuery);