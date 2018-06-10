import {config as main} from './config.js';

module.exports = function (key, config, gulp, $, errorLog) {
	return function () {

		const mainConfig = main;

		$.livereload.listen();

		gulp.watch(mainConfig.styles.args.src, ['styles']);
		for (let subtask of mainConfig.scripts.subtasks) {
			gulp.watch(`${mainConfig.scripts.args.build}${subtask}/**/*.js`, [`scripts:${subtask}`]);
		}
		gulp.watch(mainConfig.reload.args.files).on('change', $.livereload.changed);
		gulp.watch(mainConfig.svg.args.src, ['svg']);
	};
};