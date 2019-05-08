import livereload from 'gulp-livereload';

const src = [
	'*.php',
	'{classes,inc,partials,templates,includes}/**/*.{php,html,twig}'
];

module.exports = function (gulp, config) {
	return function () {
		gulp.src(src)
			.pipe(livereload());
	};
};
