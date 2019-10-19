import gulp from 'gulp';

import webpack from 'webpack';
import gulpWebpack from 'webpack-stream';
import livereload from 'gulp-livereload';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';

//import babelloader from 'babel-loader';

export const task = config => {
	return gulp.src([
			`${config.assetsBuild}gutenberg/blocks.js`
		])
		// Webpack
		.pipe(
			gulpWebpack({
				mode: 'production',
				module: {
					rules: [{
						test: /\.(js|jsx)$/,
						exclude: /(node_modules)/,
						loader: 'babel-loader'
					}]
				},
				watchOptions: {
					poll: true,
					ignored: /node_modules/
				},
				output: {
					filename: 'blocks.js'
				}
			}, webpack)
		)
		.on('error', config.errorLog)
		.pipe(gulp.dest(config.assetsDir + 'gutenberg/'))

		// Minify
		.pipe(uglify())
		.pipe(rename({
			suffix: '.min'
		}))
		.on('error', config.errorLog)
		.pipe(gulp.dest(config.assetsDir + 'gutenberg/'))

		//reload
		.pipe(livereload());
};