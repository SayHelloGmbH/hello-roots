import {config as main} from './config.js';

module.exports = function (key, config, gulp, $, errorLog) {
	return function () {

		const mainConfig = main;

		$.livereload.listen();

		console.log('watch styles..');
		gulp.watch(mainConfig.styles.args.src, ['styles']);

		for (let subtask of mainConfig.scripts.subtasks) {
			console.log(`watch scripts:${subtask}..`);
			gulp.watch(`${mainConfig.scripts.args.build}${subtask}/**/*.js`, [`scripts:${subtask}`]);
		}

		console.log('watch reload..');
		gulp.watch(mainConfig.reload.args.files).on('change', $.livereload.changed);

		console.log(`watch svg..`);
		gulp.watch(mainConfig.svg.args.src, ['svg']);
	};
};