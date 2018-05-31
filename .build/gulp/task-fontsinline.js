import merge from 'merge-stream';
import fs from 'fs';

module.exports = function (key, config, gulp, $, errorLog) {
	return function () {

		const types = ['woff', 'woff2'];
		const files = fs.readdirSync(`${config.src}source/`);
		const settings = JSON.parse(fs.readFileSync(`${config.settingsDir}settings.json`));
		const newFontver = parseInt(settings['theme_fontver']) + 1;
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

			let fontStream = merge();
			files.forEach(function (font) {

				const file = font.split('.');
				const fontElements = file[0].split('-');

				const name = fontElements[0];
				let weight = parseInt(fontElements[1]);
				let style = 'normal';

				if (typeof fontElements[1] === 'undefined') {
					weight = 400;
				} else if (fontElements[1].toLowerCase() === 'italic') {
					weight = 400;
					style = 'italc';
				} else if (isNaN(weight)) {
					for (let [num, w] of Object.entries(weights)) {
						if (w === fontElements[1].toLowerCase()) {
							weight = num;
						}
					}
				}

				let filename = font.replace('.ttf', `.${type}`);
				let fontfile = `${config.src}processed/${type}/${filename}`;

				fontStream.add(
					gulp.src(fontfile)
						.pipe($.debug({title: `inlining ${name} ${weight} ${style} (${type}):`}))
						.pipe($.inlinefonts({
								name: name,
								weight: weight,
								formats: [type],
								style: style
							})
						)
						.on('error', errorLog)
				);
			});

			if (fs.existsSync(`${config.dest}fonts-${type}.css`)) {
				fs.unlink(`${config.dest}fonts-${type}.css`);
			}

			fontStream.pipe($.concat(`fonts-${type}.css`))
				.pipe($.debug({title: `fonts-${type}.css`}))
				.pipe(gulp.dest(config.dest))
				.on('error', errorLog);
		});

		gulp.src(`${config.settingsDir}settings.json`).pipe($.jsonModify({
			key: 'theme_fontver',
			value: newFontver
		}))
			.pipe($.debug({title: 'fontver:'}))
			.pipe(gulp.dest(config.settingsDir));
	};
};