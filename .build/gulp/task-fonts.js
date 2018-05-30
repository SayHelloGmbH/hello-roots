import merge from 'merge-stream';
import fs from 'fs';

module.exports = function (key, config, gulp, $, errorLog) {
	return function () {
		console.log('converting ttf to woff...');
		gulp.src([config.src + "source/*.ttf"])
			.pipe($.ttf2woff())
			.pipe(gulp.dest(config.src + 'processed/woff/'));


		console.log('converting ttf to woff2...');
		gulp.src([config.src + "source/*.ttf"])
			.pipe($.ttf2woff2())
			.pipe(gulp.dest(config.src + 'processed/woff2/'));


		console.log('Fonts:');
		const files = fs.readdirSync(`${config.src}source/`);
		const settings = JSON.parse(fs.readFileSync(`${config.settingsDir}settings.json`));
		const newFontver = (parseFloat(settings['theme_fontver']) + 0.1).toFixed(1);

		gulp.src(`${config.settingsDir}settings.json`).pipe($.jsonModify({
			key: 'theme_fontver',
			value: newFontver
		})).pipe(gulp.dest(config.settingsDir));

		['woff', 'woff2'].forEach((type) => {

			let fontStream = merge();

			files.forEach(function (font) {

				const file = font.split('.');
				const fontElements = file[0].split('-');
				const name = fontElements[0];
				const weight = fontElements[1];
				let style = 'normal';
				if (fontElements.length === 3) {
					style = fontElements[2];
				}

				console.log(`${name} ${weight} ${style} (${type})`);

				fontStream.add(gulp.src(`${config.src}processed/${type}/${name}-${weight}.${type}`)
					.pipe($.inlinefonts({
							name: name,
							weight: weight,
							formats: [type],
							style: style
						})
					));
			});
			fontStream.pipe($.concat(`fonts-${type}.css`))
				.pipe(gulp.dest(config.dest));
		});
	};
};