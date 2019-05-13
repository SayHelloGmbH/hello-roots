import gulp from 'gulp';

import minify from 'gulp-minify-css';
import sass from 'gulp-sass';
import sassImportJson from 'gulp-sass-import-json';
import autoprefixer from 'gulp-autoprefixer';
import rename from 'gulp-rename';
import livereload from 'gulp-livereload';

export const task = config => {
	return gulp.src(config.assetsBuild + 'styles/**/*.scss')
		.pipe(sassImportJson({
			isScss: true
		}))
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
