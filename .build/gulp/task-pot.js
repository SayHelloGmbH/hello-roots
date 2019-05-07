import wpPot from 'gulp-wp-pot';

module.exports = function (key, config, gulp, $, errorLog) {
	return function () {
		gulp.src(config.src)
			.pipe(wpPot({
				domain: config.domain,
				package: config.package
			}))
			.pipe(gulp.dest(config.dest + '/' + config.domain + '.pot'));
	}
};
