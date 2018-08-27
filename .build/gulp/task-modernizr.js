import modernizr from 'gulp-modernizr';

module.exports = function(key, config, gulp, $, errorLog) {
    return function() {
        gulp.src(config.src)
            .pipe(modernizr())
            .pipe(gulp.dest(config.dest))

            // Minify
            .pipe($.uglify())
            .pipe($.rename({
                suffix: '.min'
            }))
            .on('error', errorLog)
            .pipe(gulp.dest(config.dest));
    };
};
