const assetsDir = 'assets/';
const assetsBuild = '.build/assets/';

const config = {

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

	fonts: {
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
				'**/*.html'
			]
		}
	},

	minify: {
		subtasks: ['svg', 'scripts'],
		args: {
			svg: {
				src: [
					'**/*.svg',
					'!**/*.min.svg'
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

module.exports = config;