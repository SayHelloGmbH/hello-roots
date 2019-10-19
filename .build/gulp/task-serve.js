import gulp from 'gulp';

import browserSync from 'browser-sync';

export const task = config => {
	return new Promise(resolve => {

		const flags = process.argv;

		if(flags.length > 4) {
			console.log('\nLOG: ====> to many flags (gulp server --localsiteurltoserve.com)\n');
		} else if(flags.length < 4) {
			console.log('\nLOG: ====> specify local site url to serve (gulp server --localsiteurltoserve.com)\n');
		} else {

			const url = flags[3].substring(2);
			console.log('\nSuccess: ====> ' + url + ' will be served!)\n');

			const files = [
				'assets/**/*.js',
				'assets/**/*.css',
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

		resolve();

	});
};