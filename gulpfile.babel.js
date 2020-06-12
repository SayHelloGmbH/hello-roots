import gulp from 'gulp';
import livereload from 'gulp-livereload';

const config = {
	name: 'Hello Theme',
	key: 'sht',
	assetsDir: 'assets/',
	gulpDir: './.build/gulp/',
	assetsBuild: '.build/assets/',
	errorLog: function (error) {
		console.log('\x1b[31m%s\x1b[0m', error);
		if(this.emit) {
			this.emit('end');
		}
	},
	reload: [
		'*.php',
		'{Classes,inc,partials,templates,includes}/**/*.{php,html,twig}'
	]
};

import { task as taskStyles } from './.build/gulp/task-styles';
import { task as taskScripts } from './.build/gulp/task-scripts';
import { task as taskReload } from './.build/gulp/task-reload';
import { task as taskSvg } from './.build/gulp/task-svg';
import { task as taskModernizr } from './.build/gulp/task-modernizr';
import { task as taskPot } from './.build/gulp/task-pot';
import { task as taskServe } from './.build/gulp/task-serve';
import { task as taskGutenberg } from './.build/gulp/task-gutenberg';

export const styles = () => taskStyles(config);
export const scripts = () => taskScripts(config);
export const reload = () => taskReload(config);
export const svg = () => taskSvg(config);
export const modernizr = () => taskModernizr(config);
export const pot = () => taskPot(config);
export const gutenberg = () => taskGutenberg(config);
export const serve = () => taskServe(config);
export const watch = () => {

	const settings = { usePolling: true, interval: 100 };

	livereload.listen();

	gulp.watch(config.assetsBuild + 'styles/**/*.scss', settings, gulp.series(styles));
	gulp.watch(config.assetsBuild + 'scripts/**/*.js', settings, gulp.series(scripts));
	gulp.watch(config.assetsBuild + 'gutenberg/**/*.{scss,js,jsx}', settings, gulp.series(gutenberg));
	gulp.watch(config.assetsDir + 'settings.json', settings, gulp.series(gutenberg, scripts, styles));
	gulp.watch([config.assetsDir + '**/*.svg', '!' + config.assetsDir + '**/*.min.svg'], settings, gulp.series(svg));
	gulp.watch(config.reload).on('change', livereload.changed);
};


export const taskDefault = gulp.series(gulp.parallel(styles, scripts, reload, svg), watch);
export default taskDefault;
