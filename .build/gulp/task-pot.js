import wpPot from 'gulp-wp-pot';

module.exports = function (gulp, config) {
	return function () {
		gulp.src(['**/*.php', '**/*.twig'])
			.pipe(wpPot({
				domain: config.key,
				package: config.name
			}))
			.pipe(gulp.dest(`languages/${config.key}.pot`));
	}
};
