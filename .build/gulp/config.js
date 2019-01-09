export const assetsDir = 'assets/';
export const assetsBuild = '.build/assets/';

export const config = {

	styles: {
		args: {
			src: `${assetsBuild}styles/**/*.scss`,
			dest: `${assetsDir}styles/`
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
				'*.php',
				'{classes,inc,partials,templates}/**/*.{php,html,twig}'
			]
		}
	},

	svg: {
		args: {
			src: [
				'assets/**/*.svg',
				'!assets/**/*.min.svg'
			],
			dest: 'assets/'
		}
	},

	modernizr: {
		args: {
			dest: `${assetsDir}scripts/modernizr/`,
			build: `${assetsBuild}scripts/`
		}
	},

	pot: {
		args: {
			src: ['**/*.php', '**/*.twig'],
			dest: `languages/`,
			domain: `sht`,
			package: `Hello Theme`
		}
	},

	serve: {},

	watch: {}
};
