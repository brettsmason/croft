var $        = require('gulp-load-plugins')();
var gulp     = require('gulp');
var yaml     = require('js-yaml');
var del  = require('del');
var browserSync  = require('browser-sync');
var reload       = browserSync.reload;
var fs       = require('fs');

// Load settings from config.yml
const { URL, BROWSERS, PATHS, POT, THEME } = loadConfig();

// Load our config.yml file
function loadConfig() {
  var ymlFile = fs.readFileSync('config.yml', 'utf8');
  return yaml.load(ymlFile);
}

/**
 * Handle errors and alert the user.
 */
function handleErrors() {
  var args = Array.prototype.slice.call(arguments);

  $.notify.onError({
    'title': 'Task Failed [<%= error.message %>',
    'message': 'See console.',
    'sound': 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
  }).apply(this, args);

  $.util.beep(); // Beep 'sosumi' again

  // Prevent the 'watch' task from stopping
  this.emit('end');
}

/**
 * Delete style.css and style.min.css before we minify and optimize.
 */
gulp.task('clean:styles', function() {
  return del(['style.css', 'style.min.css', 'style.css.map', 'style.min.css.map']);
});

/**
 * Compile Sass.
 *
 * https://www.npmjs.com/package/gulp-sass
 * https://www.npmjs.com/package/gulp-autoprefixer
 */
gulp.task('sass', function() {
  return gulp.src('assets/scss/style.scss')

  // Deal with errors.
  .pipe($.plumber({'errorHandler': handleErrors}))

  // Wrap tasks in a sourcemap.
  .pipe($.sourcemaps.init())

  // Compile Sass using LibSass.
  .pipe($.sass({
    'includePaths': [
      'node_modules/foundation-sites/scss',
      'node_modules/motion-ui/src'
    ],
    'errLogToConsole': true,
    'outputStyle': 'expanded',
    'indentType': 'tab',
    'indentWidth': 1
  }))

  // Parse with Autoprefixer.
  .pipe($.autoprefixer({
    'browsers': BROWSERS
  }))

  // Create sourcemap.
  .pipe($.sourcemaps.write('./'))

  // Create style.css.
  .pipe(gulp.dest('./'));
});

/**
 * Minify and optimize style.css.
 *
 * https://www.npmjs.com/package/gulp-cssnano
 */
gulp.task('cssnano', function() {
  return gulp.src('style.css')
  .pipe($.plumber({'errorHandler': handleErrors}))
  
  // Wrap tasks in a sourcemap.
  .pipe($.sourcemaps.init())

  .pipe($.cssnano({
    'safe': true // Use safe optimizations
  }))
  .pipe($.rename('style.min.css'))

  // Create sourcemap.
  .pipe($.sourcemaps.write('./'))

  .pipe(gulp.dest('./'));
});

/**
 * Delete the svg-icons.svg before we minify, concat.
 */
gulp.task('clean:icons', function() {
  return del(['assets/img/svg-icons.svg']);
});

/**
 * Minify, concatenate, and clean SVG icons.
 *
 * https://www.npmjs.com/package/gulp-svgmin
 * https://www.npmjs.com/package/gulp-svgstore
 * https://www.npmjs.com/package/gulp-cheerio
 */
gulp.task('svg', function() {
  return gulp.src(PATHS.icons)
  .pipe($.plumber({'errorHandler': handleErrors}))
  .pipe($.svgmin())
  .pipe($.rename({'prefix': 'icon-'}))
  .pipe($.svgstore({'inlineSvg': true}))
  .pipe($.cheerio({
    'run': function ($, file) {
      $('svg').attr('style', 'display:none');
      $('[fill]').removeAttr('fill');
      $('path').removeAttr('class');
    },
    'parserOptions': {'xmlMode': true}
  }))
  .pipe(gulp.dest('assets/img/'));
});

/**
 * Delete main.js and main.min.js before we concat and uglify.
 */
gulp.task('clean:scripts', function() {
  return del(['assets/js/main.js', 'assets/js/*.min.js']);
});

/**
 * Concatenate javascript files into one.
 * https://www.npmjs.com/package/gulp-concat
 */
gulp.task('concat', function() {
  return gulp.src(PATHS.javascript)
  .pipe($.plumber({'errorHandler': handleErrors}))
  .pipe($.babel({ignore: ['what-input.js']}))
  .pipe($.concat('main.js'))
  .pipe(gulp.dest('assets/js'));
});

 /**
  * Minify compiled javascript after concatenated.
  * https://www.npmjs.com/package/gulp-uglify
  */
gulp.task('uglify', function() {
  return gulp.src('assets/js/*.js')
  .pipe($.rename({'suffix': '.min'}))
  .pipe($.uglify({
    'mangle': false
  }))
  .pipe(gulp.dest('assets/js'));
});

/**
 * Delete the theme's .pot before we create a new one.
 */
gulp.task('clean:pot', function() {
  return del(['./languages/' + POT.domain + '.pot']);
});

/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('wp-pot', function() {
  return gulp.src(PATHS.php)
  .pipe($.plumber({'errorHandler': handleErrors}))
  .pipe($.sort())
  .pipe($.wpPot({
    'domain': POT.domain,
    'package': POT.package,
    'bugReport': POT.bugReport,
    'lastTranslator': POT.lastTranslator,
    'team': POT.team
  }))
  .pipe(gulp.dest('./languages/' + POT.domain + '.pot'));
});

/**
 * Process tasks and reload browsers on file changes.
 *
 * https://www.npmjs.com/package/browser-sync
 */
gulp.task('watch', function() {

  // Kick off BrowserSync.
  browserSync({
    'open': false,
    'injectChanges': true,
    'proxy': URL,
    'watchOptions': {
      'debounceDelay': 1000
    }
  });

  // Run tasks when files change.
  gulp.watch(PATHS.icons, gulp.parallel('icons'));
  gulp.watch('assets/scss/**/*.scss', gulp.parallel('styles'));
  gulp.watch(PATHS.javascript, gulp.parallel('scripts'));
  gulp.watch(PATHS.php, gulp.parallel('markup'));
});

/**
 *  Rename all theme specific strings with new ones.
 *  These are set in config.yml.
 */
gulp.task('rename', function() {
  return gulp.src(['**/*', '!inc/hybrid-core/**', '!node_modules/**'])
    .pipe($.replace(THEME.CURRENT.name, THEME.NEW.name))
    .pipe($.replace(THEME.CURRENT.slug, THEME.NEW.slug))
    .pipe($.replace(THEME.CURRENT.prefix, THEME.NEW.prefix))
    .pipe(gulp.dest('./'));
});

/**
 * Create individual tasks.
 */
gulp.task('markup', browserSync.reload);
gulp.task('i18n', gulp.series('clean:pot', 'wp-pot'));
gulp.task('icons', gulp.series('clean:icons', 'svg'));
gulp.task('scripts', gulp.series('clean:scripts', 'concat', 'uglify'));
gulp.task('styles', gulp.series('clean:styles', 'sass', 'cssnano'));
gulp.task('default', gulp.parallel('i18n', 'icons', 'styles', 'scripts'));