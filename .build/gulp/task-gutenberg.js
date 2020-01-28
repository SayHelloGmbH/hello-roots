import gulp from 'gulp';

import webpack from 'webpack';
import gulpWebpack from 'webpack-stream';
import livereload from 'gulp-livereload';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';

//import babelloader from 'babel-loader';

const wplib = [
	'blocks',
	'components',
	'date',
	'editor',
	'element',
	'i18n',
	'utils',
	'data',
];

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
					filename: 'blocks.js',
					library: ['wp', 'i18n'],
					libraryTarget: 'window'
				},
				externals: wplib.reduce((externals, lib) => {
					externals[`wp.${lib}`] = {
						window: ['wp', lib],
					};
					return externals;
				}, {}),
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