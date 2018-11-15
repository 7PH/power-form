/**
 * @license MIT
 */

const browserify = require('browserify');
const buffer = require('vinyl-buffer');
const fs = require('fs-extra');
const gulp = require('gulp');
const source = require('vinyl-source-stream');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');

const BUILD_DIR = 'build';
const OUT_DIR = "dist";

/**
 * Bundle JavaScript files produced by the `tsc` task, into a single file named `xterm.js` with
 * Browserify.
 */
gulp.task('build-bundle', function() {

    // Ensure that the build directory exists
    fs.ensureDirSync(BUILD_DIR);

    let browserifyOptions = {
        basedir: BUILD_DIR,
        debug: true,
        entries: [`app/client/index.js`],
        cache: {},
        packageCache: {}
    };

    return browserify(browserifyOptions)
        .bundle()
        .pipe(source('index.js'))
        .pipe(buffer())
        .pipe(sourcemaps.init({loadMaps: true, sourceRoot: '..'}))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(OUT_DIR));

    // Copy stylesheets from ${OUT_DIR}/ to ${BUILD_DIR}/
    // let copyStylesheets = gulp.src(`${OUT_DIR}/**/*.css`).pipe(gulp.dest(BUILD_DIR));
    //return merge(bundleStream, copyStylesheets);
});


gulp.task('default', gulp.parallel('build-bundle'));
