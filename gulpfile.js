var $        = require('gulp-load-plugins')();
var gulp     = require('gulp');
var yaml     = require('js-yaml');

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

  notify.onError({
    'title': 'Task Failed [<%= error.message %>',
    'message': 'See console.',
    'sound': 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
  }).apply(this, args);

  gutil.beep(); // Beep 'sosumi' again

  // Prevent the 'watch' task from stopping
  this.emit('end');
}

/**
 * Delete style.css and style.min.css before we minify and optimize.
 */
gulp.task('clean:styles', function() {
  return del(['style.css', 'style.min.css']);
} );

/**
 * Compile Sass.
 *
 * https://www.npmjs.com/package/gulp-sass
 * https://www.npmjs.com/package/gulp-autoprefixer
 */
gulp.task('sass', ['clean:styles'], function() {
  return gulp.src('assets/scss/style.scss')

  // Deal with errors.
  .pipe(plumber({'errorHandler': handleErrors}))

  // Wrap tasks in a sourcemap.
  .pipe(sourcemaps.init())

  // Compile Sass using LibSass.
  .pipe(sass({
    'includePaths': [
      'bower_components/foundation-sites/scss',
      'bower_components/motion-ui/src'
    ],
    'errLogToConsole': true,
    'outputStyle': 'expanded',
    'indentType': 'tab',
    'indentWidth': 1
  }))

  // Parse with Autoprefixer.
  .pipe(autoprefixer({
    'browsers': BROWSERS
  }))

  // Create sourcemap.
  .pipe(sourcemaps.write('./'))

  // Create style.css.
  .pipe(gulp.dest('./'));
});

/**
 * Minify and optimize style.css.
 *
 * https://www.npmjs.com/package/gulp-cssnano
 */
gulp.task('cssnano', ['sass'], function() {
  return gulp.src('style.css')
  .pipe( plumber({'errorHandler': handleErrors}))
  .pipe( cssnano({
    'safe': true // Use safe optimizations
  }))
  .pipe(rename('style.min.css'))
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
gulp.task('svg', ['clean:icons'], function() {
  return gulp.src(paths.icons)
  .pipe( plumber({'errorHandler': handleErrors}))
  .pipe(svgmin())
  .pipe(rename({'prefix': 'icon-'}))
  .pipe(svgstore({'inlineSvg': true}))
  .pipe(cheerio({
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
 * Concatenate javascript files into one.
 * https://www.npmjs.com/package/gulp-concat
 */
gulp.task('concat', function() {
  return gulp.src(paths.customScripts)
  .pipe(plumber({'errorHandler': handleErrors}))
  .pipe(babel({ignore: ['what-input.js']}))
  .pipe(concat('main.js'))
  .pipe(gulp.dest('assets/js'));
});

 /**
  * Minify compiled javascript after concatenated.
  * https://www.npmjs.com/package/gulp-uglify
  */
gulp.task('uglify', ['concat'], function() {
  return gulp.src(paths.scripts)
  .pipe(rename({'suffix': '.min'}))
  .pipe(uglify({
    'mangle': false
  }))
  .pipe(gulp.dest('assets/js'));
});

/**
 * Delete the theme's .pot before we create a new one.
 */
gulp.task('clean:pot', function() {
  return del(['languages/legion.pot']);
});

/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('wp-pot', ['clean:pot'], function() {
  return gulp.src(paths.php)
  .pipe(plumber({'errorHandler': handleErrors}))
  .pipe(sort())
  .pipe(wpPot({
    'domain': 'croft',
    'destFile': 'croft.pot',
    'package': 'legion',
    'bugReport': 'https://github.com/brettsmason/croft/issues',
    'lastTranslator': 'Brett Mason <brettsmason@gmail.com>',
    'team': 'Brett Mason <brettsmason@gmail.com>'
  }))
  .pipe(gulp.dest('languages/'));
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
    'proxy': paths.server,
    'watchOptions': {
      'debounceDelay': 1000
    }
  });

  // Run tasks when files change.
  gulp.watch(paths.icons, ['icons']);
  gulp.watch(paths.sass, ['styles']);
  gulp.watch(paths.customScripts, ['scripts']);
  gulp.watch(paths.vendorScripts, ['scripts']);
  gulp.watch(paths.php, ['markup']);
});

/**
 * Create individual tasks.
 */
gulp.task('markup', browserSync.reload);
gulp.task('i18n', ['wp-pot']);
gulp.task('icons', ['svg']);
gulp.task('scripts', ['uglify']);
gulp.task('styles', ['cssnano']);
gulp.task('default', ['i18n', 'icons', 'styles', 'scripts']);