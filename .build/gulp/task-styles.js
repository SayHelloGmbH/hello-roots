import gulp from 'gulp';

import cleanCSS from 'gulp-clean-css';
import sass from 'gulp-sass';
import sassImportJson from 'gulp-sass-import-json';
import autoprefixer from 'gulp-autoprefixer';
import rename from 'gulp-rename';
import livereload from 'gulp-livereload';
import sourcemaps from 'gulp-sourcemaps';

export const task = config => {
	return gulp.src(config.assetsBuild + 'styles/**/*.scss')
		.pipe(sassImportJson({ isScss: true }))
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer())
		.pipe(gulp.dest(config.assetsDir + 'styles/'))
		.pipe(sourcemaps.write('.'))
		.on('error', config.errorLog)
		// minify
		.pipe(cleanCSS())
		.pipe(rename({
			suffix: '.min'
		}))
		.on('error', config.errorLog)
		.pipe(gulp.dest(config.assetsDir + 'styles/'))
		//reload
		.pipe(livereload());
};