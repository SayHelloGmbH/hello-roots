import browserSync from 'browser-sync';
import gulpif from 'gulp-if';
import argv from 'yargs';

module.exports = function(key, config, gulp, $, errorLog) {
	return function() {

		let flags = process.argv;

		if (flags.length > 4) {
			console.log('\nLOG: ====> to many flags (gulp server --localsiteurltoserve.com)\n');
		} else if (flags.length < 4) {
			console.log('\nLOG: ====> specify local site url to serve (gulp server --localsiteurltoserve.com)\n');
		} else {

			let url = flags[3].substring(2);

			console.log('\nSuccess: ====> ' + url + ' will be served!)\n');

			let files = [
				'js/**/*.js',
				'css/**/*.css',
				'**/*.php',
				'**/*.{png,jpg,gif}'
			];

			browserSync.init(files, {
				open: false,
				port: "9090",
				proxy: {
					target: url
				}
			});

		}

	}
}
