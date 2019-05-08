import minify from 'gulp-minify-css';
import sass from 'gulp-sass';
import sassImportJson from 'gulp-sass-import-json';
import autoprefixer from 'gulp-autoprefixer';
import rename from 'gulp-rename';
import livereload from 'gulp-livereload';

module.exports = function (gulp, config) {
	return function () {
		gulp.src(config.assetsBuild + 'styles/**/*.scss')
			.pipe(sassImportJson({isScss: true}))
			.pipe(sass().on('error', sass.logError))
			.pipe(autoprefixer())
			.pipe(gulp.dest(config.assetsDir + 'styles/'))
			.on('error', config.errorLog)
			// minify
			.pipe(minify())
			.pipe(rename({
				suffix: '.min'
			}))
			.on('error', config.errorLog)
			.pipe(gulp.dest(config.assetsDir + 'styles/'))
			//reload
			.pipe(livereload());
	};
};
/*
module.exports = function(key, config, gulp, $, errorLog) {
	return function() {
		gulp.src(config.src)
			.pipe(sassImportJson({ isScss: true }))
			.pipe(sass().on('error', sass.logError))
			.pipe($.autoprefixer({
				browsers: [
					'> 1%',
					'IE 11'
				]
			}))
			.pipe(gulp.dest(config.dest))
			.on('error', errorLog)
			// minify
			.pipe(minify())
			.pipe($.rename({
				suffix: '.min'
			}))
			.on('error', errorLog)
			.pipe(gulp.dest(config.dest))
			//reload
			.pipe($.livereload());
	};
};
*/
