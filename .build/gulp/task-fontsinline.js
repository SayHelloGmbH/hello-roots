/**
 * Written by Nico Martin - mail@nicomartin.ch
 * Use normalized file names: name-weight-style.ttf
 * e.g. lato-400-normal.ttf
 * e.g. late-700-italic.ttf
 */

import merge from 'merge-stream';
import fs from 'fs';
import inlineFonts from './modules/nm-inline-fonts.js';

module.exports = function(key, config, gulp, $, errorLog) {
	return function() {

		const types = ['woff', 'woff2'];
		const files = fs.readdirSync(`${config.src}source/`);
		const weights = {
			100: 'thin',
			200: 'extralight',
			300: 'light',
			400: 'normal',
			500: 'medium',
			600: 'semibold',
			700: 'bold',
			800: 'extrabold',
			900: 'black'
		};

		types.forEach((type) => {

			const fontStream = merge();
			files.forEach(function(font) {

				const file = font.split('.');
				const fontElements = file[0].split('-');

				const name = fontElements[0];
				let weight = parseInt(fontElements[1]);
				let style = 'normal';

				if (typeof fontElements[1] === 'undefined') {
					weight = 400;
				} else if (fontElements[1].toLowerCase() === 'italic') {
					weight = 400;
					style = 'italic';
				} else if (isNaN(weight)) {
					for (let [num, w] of Object.entries(weights)) {
						if (w === fontElements[1].toLowerCase()) {
							weight = num;
						}
					}
				}

				let filename = font.replace('.ttf', `.${type}`);
				let fontfile = `${config.src}processed/${type}/${filename}`;

				fontStream.add(gulp.src(fontfile)
					.pipe($.debug({ title: `inlining ${name} ${weight} ${style} (${type}):` }))
					.pipe(inlineFonts({
						name: name,
						weight: weight,
						formats: [type],
						style: style
					}))
					.on('error', errorLog));
			});

			if (fs.existsSync(`${config.dest}fonts-${type}.css`)) {
				fs.unlink(`${config.dest}fonts-${type}.css`);
			}

			fontStream.pipe($.concat(`fonts-${type}.css`))
				.pipe($.debug({ title: `fonts-${type}.css` }))
				.pipe(gulp.dest(config.dest))
				.on('error', errorLog);
		});
	};
};
