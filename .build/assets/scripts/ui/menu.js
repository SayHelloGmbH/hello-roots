(function ($) {
	$(function () {

		const $toggler = $('[aria-controls="mobile-menu"]');
		const navID = $toggler.attr('aria-controls');
		const $nav = $(`#${navID}`);

		$toggler.on('click', function () {

			if(!$nav.length) {
				console.log(`navigation #${navID} not found`);
				return;
			}

			const open = ($toggler.attr('aria-expanded') === 'true');

			if(open) {
				$toggler.attr('aria-expanded', 'false');
				$nav.attr('aria-expanded', 'false');
			} else {
				$toggler.attr('aria-expanded', 'true');
				$nav.attr('aria-expanded', 'true');
			}
		});
	});
})(jQuery);