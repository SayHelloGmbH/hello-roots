import gulp from 'gulp';

import livereload from 'gulp-livereload';

export const task = config => {
	return gulp.src(config.reload)
		.pipe(livereload());
};