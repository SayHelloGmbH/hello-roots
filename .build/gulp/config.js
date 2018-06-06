export const assetsDir = 'assets/';
export const assetsBuild = '.build/assets/';

export const config = {

	styles: {
		args: {
			src: `${assetsBuild}styles/**/*.scss`,
			compass: {
				css: `${assetsDir}styles/`,
				image: `${assetsDir}img/`,
				sass: `${assetsBuild}styles/`,
				style: 'expanded'
			}
		}
	},

	fontsconvert: {
		args: {
			src: `${assetsBuild}fonts/`,
			dest: `${assetsDir}fonts/`
		},
	},

	fontsinline: {
		args: {
			src: `${assetsBuild}fonts/`,
			dest: `${assetsDir}fonts/`,
			settingsDir: assetsDir
		},
	},

	scripts: {
		subtasks: [
			'ui',
			'admin',
			'tinymce'
		],
		args: {
			base: `${assetsDir}scripts/`,
			build: `${assetsBuild}scripts/`
		}
	},

	reload: {
		args: {
			files: [
				'**/*.php',
				'**/*.html',
				'!node_modules/**'
			]
		}
	},

	minify: {
		subtasks: ['svg', 'scripts'],
		args: {
			svg: {
				src: [
					'**/*.svg',
					'!**/*.min.svg',
					'!node_modules/**'
				],
				dest: './'
			},
			scripts: {
				src: [
					`${assetsDir}scripts/*.js`,
					`!${assetsDir}scripts/*.min.js`
				],
				dest: './',
				base: `${assetsDir}scripts/`,
				build: `${assetsBuild}scripts/`
			}
		}
	},

	watch: {}
};