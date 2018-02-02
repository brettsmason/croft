'use strict';

const $       = require('gulp-load-plugins')();
const browser = require('browser-sync');
const gulp    = require('gulp');
const rimraf  = require('rimraf');
const yaml    = require('js-yaml');
const fs      = require('fs');

// Load settings from config.yml
const { URL, AUTOPREFIXER, PATHS, POT, THEME } = loadConfig();

function loadConfig() {
  let ymlFile = fs.readFileSync('config.yml', 'utf8');
  return yaml.load(ymlFile);
}

// Delete the "dist" folder
// This happens every time a build starts
function clean(done) {
  rimraf(PATHS.dist, done);
}

// Compile and minify the main theme stylesheet.
function sass() {
  return gulp.src('assets/scss/style.scss')
    .pipe($.sourcemaps.init())
    .pipe($.sass({
      includePaths: PATHS.sass,
      outputStyle: 'expanded',
      indentType: 'tab',
      indentWidth: 1
    })
    .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: AUTOPREFIXER
    }))
    .pipe(gulp.dest('./'))
    .pipe($.cleanCss({compatibility: 'ie10'}))
    .pipe($.rename({'suffix': '.min'}))
    .pipe($.sourcemaps.write('./'))
    .pipe(gulp.dest('./'));
}

// Compile and minify WordPress editor stylesheet.
function sassEditor() {
  return gulp.src('assets/scss/editor-style.scss')
    .pipe($.sass({
      includePaths: PATHS.sass,
      outputStyle: 'compressed'
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: AUTOPREFIXER
    }))
    .pipe($.rename({'suffix': '.min'}))
    .pipe(gulp.dest('assets/css'));
}

// Concatenate and minify JavaScript files.
function javascript() {
  return gulp.src(PATHS.javascript)
    .pipe($.concat('main.js'))
    .pipe(gulp.dest('assets/js'))
    .pipe($.rename({'suffix': '.min'}))
    .pipe($.uglify({'mangle': false}))
    .pipe(gulp.dest('assets/js'))
    .pipe(gulp.dest('assets/js'));
}

// Minify, concatenate, and clean SVG icons.
function svg() {
  return gulp.src(PATHS.icons)
  .pipe($.svgmin())
  .pipe($.rename({'prefix': 'icon-'}))
  .pipe($.svgstore({'inlineSvg': true}))
  .pipe($.cheerio({
    run: function ($, file) {
      $('svg').attr('style', 'display:none');
      $('[fill]').removeAttr('fill');
      $('path').removeAttr('class');
    },
    parserOptions: {'xmlMode': true}
  }))
  .pipe(gulp.dest('assets/img'));
}

// Scan the theme and create a POT file.
function translate() {
  return gulp.src(PATHS.php)
    .pipe($.sort())
    .pipe($.wpPot({
      domain: POT.domain,
      package: POT.package
    }))
    .pipe(gulp.dest('languages/' + POT.domain + '.pot'));
}

// Start a server with BrowserSync to preview the site in.
function server(done) {
  browser.init({
    proxy: URL,
    injectChanges: true
  });
  done();
}

// Reload the browser with BrowserSync.
function reload(done) {
  browser.reload();
  done();
}

// Watch for changes to assets and php files.
function watch() {
  gulp.watch('assets/scss/**/*.scss').on('all', gulp.series(gulp.parallel(sass)));
  gulp.watch('assets/js/**/*.js').on('all', gulp.series(javascript, browser.reload));
  gulp.watch('assets/img/**/*.svg').on('all', gulp.series(svg, browser.reload));
  gulp.watch('**/*.php').on('all', gulp.series(browser.reload));
}

// Build the assets by running all of the below tasks
gulp.task('build', gulp.parallel(sass, sassEditor, javascript, svg, translate));

// Build the assets, run the server, and watch for file changes
gulp.task('default', gulp.series('build', server, watch));