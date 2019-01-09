import { config as main } from './config.js';
import modernizr from 'gulp-modernizr';

module.exports = function(key, config, gulp, $, errorLog) {
	return function() {

		const mainConfig = main;
		//console.log(mainConfig.scripts);

		for (let i = 0; i < mainConfig.scripts.subtasks.length; i++) {

			const key = mainConfig.scripts.subtasks[i];

			gulp.src([
					`${config.build + key}/*.js`
				])
				.pipe(modernizr(`${key}-modernizr.js`))

				// Minify
				.pipe($.uglify())
				.pipe($.rename({
					suffix: '.min'
				}))
				.on('error', errorLog)
				.pipe(gulp.dest(config.dest));

		}
	};
};
