import gulp from 'gulp';

import gulpWebpack from 'webpack-stream';
import named from 'vinyl-named';

import livereload from 'gulp-livereload';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';
import fs from 'fs';

const getDirectories = path =>
    fs.readdirSync(path).filter(file => fs.statSync(path + '/' + file).isDirectory());

export const task = config => {
    return new Promise(resolve => {
        gulp.src(
            getDirectories(`${config.assetsBuild}scripts/`).map(
                bundle => `${config.assetsBuild}scripts/${bundle}.js`
            )
        )
            .pipe(named())
            // Webpack
            .pipe(
                gulpWebpack({
                    mode: 'production',
                    module: {
                        rules: [
                            {
                                test: /\.js$/,
                                exclude: /node_modules/,
                                loader: 'babel-loader',
                            },
                            {
                                test: /\.css$/i,
                                use: ['style-loader', 'css-loader'],
                            },
                        ],
                    },
                    output: {
                        filename: '[name].js',
                    },
                    externals: {
                        jquery: 'jQuery',
                    },
                })
            )
            .on('error', config.errorLog)
            .pipe(gulp.dest(config.assetsDir + 'scripts/'))

            // Minify
            .pipe(uglify())
            .pipe(
                rename({
                    suffix: '.min',
                })
            )
            .on('error', config.errorLog)
            .pipe(gulp.dest(config.assetsDir + 'scripts/'))

            //reload
            .pipe(livereload());
        resolve();
    });
};
