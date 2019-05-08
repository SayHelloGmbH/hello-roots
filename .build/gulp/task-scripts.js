import webpack from 'webpack';
import gulpWebpack from 'webpack-stream';
import livereload from 'gulp-livereload';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';
import fs from "fs";

import babelloader from 'babel-loader';

module.exports = function (gulp, config) {
	return function () {

		function getDirectories(path) {
			return fs.readdirSync(path).filter(function (file) {
				return fs.statSync(path + '/' + file).isDirectory();
			});
		}

		getDirectories(`${config.assetsBuild}scripts/`).forEach(bundle => {
			gulp.src([
				`${config.assetsBuild}scripts/${bundle}/*.js`
			])
			// Webpack
				.pipe(
					gulpWebpack({
						module: {
							rules: [{
								test: /\.js$/,
								exclude: /node_modules/,
								loader: "babel-loader"
							}]
						},
						output: {
							filename: `${bundle}.js`
						},
						externals: {
							"jquery": "jQuery"
						}
					}, webpack)
				)
				.on('error', config.errorLog)
				.pipe(gulp.dest(config.assetsDir + 'scripts/'))

				// Minify
				.pipe(uglify())
				.pipe(rename({
					suffix: '.min'
				}))
				.on('error', config.errorLog)
				.pipe(gulp.dest(config.assetsDir + 'scripts/'))

				//reload
				.pipe(livereload());
		});
	}
};
