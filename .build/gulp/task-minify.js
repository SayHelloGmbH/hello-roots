module.exports = function (key, config, gulp, $, errorLog) {
	if (key === 'scripts') {
		return function () {
			gulp.src(config.scripts.src)
				.pipe($.debug({title: 'minify script:'}))
				.pipe($.uglify())
				.pipe($.rename({
					suffix: '.min'
				}))
				.on('error', errorLog)
				.pipe(gulp.dest(config.scripts.base))
				.pipe($.livereload());
		};
	} else if (key === 'svg') {
		return function () {
			gulp.src(config.svg.src)
				.pipe($.debug({title: 'minify svg:'}))
				.pipe($.svgmin())
				.pipe($.rename({
					suffix: '.min'
				}))
				.on('error', errorLog)
				.pipe(gulp.dest(config.svg.dest));
		};
	}
};