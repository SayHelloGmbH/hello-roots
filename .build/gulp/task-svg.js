import rename from 'gulp-rename';
import svgmin from 'gulp-svgmin';
import livereload from "gulp-livereload";

module.exports = function (gulp, config) {
	return function () {
		gulp.src([
			config.assetsDir + '**/*.svg',
			'!' + config.assetsDir + '**/*.min.svg'
		])
			.pipe(svgmin())
			.pipe(rename({
				suffix: '.min'
			}))
			.on('error', config.errorLog)
			.pipe(gulp.dest(config.assetsDir))
			//reload
			.pipe(livereload());
	};
};
