import gulp from 'gulp';

import wpPot from 'gulp-wp-pot';

export const task = config => {
	return gulp.src(['**/*.php', '**/*.twig'])
		.pipe(wpPot({
			domain: config.key,
			package: config.name
		}))
		.pipe(gulp.dest(`languages/${config.key}.pot`));
};