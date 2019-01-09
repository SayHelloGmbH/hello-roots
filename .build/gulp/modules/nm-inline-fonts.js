var through2 = require('through2');
var gutil = require('gulp-util');
var path = require('path');
var mime = require('mime');
var PluginError = gutil.PluginError;

var mimes = {
	woff: 'application/font-woff',
	woff2: 'application/font-woff2',
	ttf: 'application/x-font-truetype',
	eot: 'application/vnd.ms-fontobject',
	otf: 'application/x-font-opentype',
	svg: 'image/svg+xml'
};

var cssFormats = {
	ttf: 'truetype',
	otf: false
};

module.exports = function(custom) {
	var fonts = [],
		options = { name: 'font', style: 'normal', weight: 400, formats: ['woff', 'woff2'], stretch: 'normal' },
		output = null;

	for (var attr in custom) {
		options[attr] = custom[attr]
	}

	function process(file) {
		var mime_type = mime.getType(file.path);
		var mime_ext = mime.getExtension(mime_type);

		if (!mimes[mime_ext]) return;
		var cssFormat = cssFormats[mime_ext];
		if (cssFormat === undefined) cssFormat = mime_ext;
		if (cssFormat !== false) cssFormat = 'format("' + cssFormat + '")';

		return {
			format: mime_ext,
			cssFormat: cssFormat,
			compile: function() {
				return 'url("data:' + mime_type + ';base64,' + file.contents.toString('base64') + '")' +
					(cssFormat ? ' ' + cssFormat : '');
			}
		}
	}

	var transform = function(file, encoding, cb) {
		if (file.isBuffer()) {
			var font = process(file);

			if (font && options.formats.indexOf(font.format) != -1) {
				fonts.push(font);

				if (!output) {
					output = new gutil.File({
						cwd: file.cwd,
						base: file.base,
						path: path.join(file.base, options.name + '.css')
					});
				}
			}
		} else if (file.isStream()) {
			this.emit('error', new PluginError('gulp-inline-fonts', 'Streaming is not supported'));
		}

		cb();
	}

	var flush = function(cb) {
		// if there are no matched files
		if (!output) return cb();
		var fontGroups = fonts.reduce(function(acc, font) {
			acc[font.cssFormat ? 1 : 0].push(font);
			return acc;
		}, [
			[],
			[]
		]);
		var content = '@font-face { ' +
			'font-family: "' + options.name + '"; ' +
			'font-style: ' + options.style + '; ' +
			'font-stretch: ' + options.stretch + '; ' +
			'font-weight: ' + options.weight + '; ' +
			fontGroups[0].map(function(f) {
				return 'src: ' + f.compile() + '; '
			}).join('') +
			'src: ' + fontGroups[1].map(function(f) {
				return f.compile()
			}).join(', ') + '; ' +
			'}';
		output.contents = new Buffer(content);
		this.push(output);

		cb();
	}

	return through2.obj({}, transform, flush);
};
