module.exports = function (key, config, gulp, $, errorLog) {
	return function () {

		const types = ['woff', 'woff2'];
		const convert = function (thetype) {
			if ('woff' === thetype) {
				return $.ttf2woff();
			} else if ('woff2' === thetype) {
				return $.ttf2woff2();
			}
		};

		types.forEach((type) => {
			gulp.src([config.src + "source/*.ttf"])
				.pipe($.debug({title: `converting ttf to ${type}:`}))
				.pipe(convert(type)).on('error', errorLog)
				.pipe(gulp.dest(`${config.src}processed/${type}/`)).on('error', errorLog);
		});
	};
};