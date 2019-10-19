(function ($) {

	const CheckClass = 'no-outline';
	const $body = $('body');

	$(function () {

		$body.addClass(CheckClass);

		$(window).keydown(function (e) {
			const code = (e.keyCode ? e.keyCode : e.which);
			if(code === 9) {
				$body.removeClass(CheckClass);
			}
		});

		$(window).mousemove(function (e) {
			$body.addClass(CheckClass);
		});
	});
})(jQuery);