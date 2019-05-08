import livereload from 'gulp-livereload';

module.exports = function (gulp, config) {
	return function () {

		livereload.listen();

		gulp.watch(config.assetsBuild + 'styles/**/*.scss', {interval: 500}, ['styles']);
		gulp.watch(config.assetsBuild + 'scripts/**/*.js', {interval: 500}, ['scripts']);
		gulp.watch([
			config.assetsDir + '**/*.svg',
			'!' + config.assetsDir + '**/*.min.svg'
		], {interval: 500}, ['svg']);
		gulp.watch(['*.php', '{classes,inc,partials,templates,includes}/**/*.{php,html,twig}']).on('change', livereload.changed);
	};
};
