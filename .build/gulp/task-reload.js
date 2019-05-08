import gulp from 'gulp';

import livereload from 'gulp-livereload';

const src = [
	'*.php',
	'{classes,inc,partials,templates,includes}/**/*.{php,html,twig}'
];

export const task = config => {
	return gulp.src(src)
		.pipe(livereload());
};
