import gulp from 'gulp';
import fs from 'fs';

const tasksDefault = [
	'styles',
	'scripts',
	'reload',
	'svg',
	'watch'
];

const tasks = tasksDefault.concat([
	'modernizr',
	'pot'
]);

const config = {
	name: 'Hello Theme',
	key: 'sht',
	assetsDir: 'assets/',
	gulpDir: './.build/gulp/',
	assetsBuild: '.build/assets/',
	errorLog: function (error) {
		console.log('\x1b[31m%s\x1b[0m', error);
		if (this.emit) {
			this.emit('end');
		}
	}
};

function getTask(task) {
	const path = `${config.gulpDir}task-${task}`;

	if (fs.existsSync(path + '.js')) {
		return require(path)(gulp, config);
	} else {
		console.log('\x1b[31m%s\x1b[0m', `task "${task}" not found`);
	}
}

/**
 * ----------------
 * TASKS ----------
 * ----------------
 */

tasks.forEach(file => {
	const task = file.replace('task-', '').replace('.js', '');
	gulp.task(task, getTask(task));
});

gulp.task('default', tasksDefault);
