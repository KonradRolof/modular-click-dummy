// load plugins
var sequence = require('run-sequence'),
    cleanCss = require('gulp-clean-css'),
    stylish = require('jshint-stylish'),
    rimraf = require('rimraf'),
    argv = require('yargs').argv,
    gulp = require('gulp');

// Include plugins
var $ = require("gulp-load-plugins")({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
});

// Check for --production flag
var isProduction = !!(argv.prod);

// Browsers to target when prefixing CSS.
var COMPATIBILITY = ['last 2 versions', 'ie >= 9'];

// File paths to various assets are defined here.
var PATHS = {
    assets: {
        src: 'src/img/**/*.{png,jpeg,jpg,gif,svg}',
        dist: 'img',
        watch: ['src/img', 'src/img/**/*']
    },
    fonts: {
        src: 'src/fonts/**/*.{ttf,woff,eot,svg,woff2}',
        dist: 'fonts'
    },
    styles: {
        src: 'src/scss/*.scss',
        dist: 'css',
        includes: [
            'bower_components/foundation-sites/scss'
        ],
        watch: ['./src/scss/**/*.scss']
    },
    scripts: {
        src: [
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/foundation-sites/dist/js/plugins/foundation.core.js',
            'bower_components/foundation-sites/dist/js/plugins/foundation.util.*.js',
            'bower_components/foundation-sites/dist/js/plugins/foundation.equalizer.js',
            'bower_components/slick-carousel/slick/slick.min.js',
            'src/js/app.js'
        ],
        dist: 'js',
        hint: './src/js/**/*.js',
        watch: ['src/js/**/*.js']
    }
};

// Delete the "dist" folder
// This happens every time a build starts
gulp.task('clean', function (callback) {
    rimraf('./dist', callback);
});

// Compile Sass into CSS
gulp.task('sass', function () {
    var minifyCss = $.if(isProduction, cleanCss());

    return gulp.src(PATHS.styles.src)
        .pipe($.sourcemaps.init())
        .pipe($.sass({
            includePaths: PATHS.styles.includes,
            outputStyle: 'compact'
        })
            .on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browsers: COMPATIBILITY
        }))
        .pipe(minifyCss)
        .pipe($.if(!isProduction, $.sourcemaps.write()))
        .pipe(gulp.dest(PATHS.styles.dist));
});

// js validation for normal case coding
gulp.task('jshint', function () {
    return gulp.src(PATHS.scripts.hint)
        .pipe($.jshint())
        .pipe($.jshint.reporter(stylish));
});

// Combine JavaScript into one file
gulp.task('javascript', function () {
    var uglify = $.if(isProduction, $.uglify()
        .on('error', function (e) {
            console.log(e);
        }));

    return gulp.src(PATHS.scripts.src)
        .pipe($.concat('app.js'))
        .pipe(uglify)
        .pipe(gulp.dest(PATHS.scripts.dist));
});

// Compress images
gulp.task('images', function (cb) {
    return gulp.src(PATHS.assets.src)
        .pipe($.changed(PATHS.assets.dist))
        .pipe($.imagemin({
            optimizationLevel: 5,
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            interlaced: true
        }))
        .pipe(gulp.dest(PATHS.assets.dist));
});

// Copy font awesome font files to font dir
gulp.task('copyfonts', function() {
    return gulp.src(PATHS.fonts.src)
        .pipe($.changed(PATHS.fonts.dist))
        .pipe(gulp.dest(PATHS.fonts.dist));
});

// Build the "dist" folder by running all of the above tasks
gulp.task('build', function (done) {
    sequence('clean', ['sass', 'jshint', 'javascript', 'images', 'copyfonts'], done);
});

// Build the site, and watch for file changes
gulp.task('default', ['build'], function () {
    gulp.watch(PATHS.styles.watch, ['sass']);
    gulp.watch(PATHS.scripts.watch, ['jshint', 'javascript']);
    gulp.watch(PATHS.assets.watch, ['images']);
});