import modernizr from 'gulp-modernizr';
import fs from "fs";
import rename from "gulp-rename";
import uglify from "gulp-uglify";

module.exports = function (gulp, config) {
	return function () {

		function getDirectories(path) {
			return fs.readdirSync(path).filter(function (file) {
				return fs.statSync(path + '/' + file).isDirectory();
			});
		}

		getDirectories(`${config.assetsBuild}scripts/`).forEach(bundle => {
			gulp.src([
				`${config.assetsDir}scripts/${bundle}.js`
			])
				.pipe(modernizr(`${bundle}-modernizr.js`))

				// Minify
				.pipe(uglify())
				.pipe(rename({
					suffix: '.min'
				}))
				.on('error', config.errorLog)
				.pipe(gulp.dest(config.assetsDir + 'scripts/modernizr/'))

		});
	};
};
