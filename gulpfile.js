var $        = require('gulp-load-plugins')();
var pkg      = require('./package.json');
var gulp     = require('gulp');
var rimraf   = require('rimraf');
var sequence = require('run-sequence');

// Browsers to target when prefixing CSS.
var COMPATIBILITY = ['last 2 versions', 'ie >= 9'];

var THEME = {
  current: {
    name: "Croft",
    slug: "croft",
    prefix: "croft_"
  },
  new: {
    name: "Croft",   // Theme name
    slug: "croft",   // Themes textdomain
    prefix: "croft_" // Theme prefix - used for function names
  }
}

// File paths to various assets are defined here.
var PATHS = {
  hc: [
    'bower_components/hybrid-core/**'
  ],
  sass: [
    'bower_components/foundation-sites/scss',
    'bower_components/motion-ui/src'
  ],
  javascript: [
    // What-input
    'bower_components/what-input/what-input.js',

    // Foundation Core and utils
    'bower_components/foundation-sites/js/foundation.core.js',
    'bower_components/foundation-sites/js/foundation.util.*.js',

    // Individual Foundation JS components
    'bower_components/foundation-sites/js/foundation.abide.js',
    'bower_components/foundation-sites/js/foundation.accordion.js',
    'bower_components/foundation-sites/js/foundation.accordionMenu.js',
    'bower_components/foundation-sites/js/foundation.drilldown.js',
    'bower_components/foundation-sites/js/foundation.dropdown.js',
    'bower_components/foundation-sites/js/foundation.dropdownMenu.js',
    'bower_components/foundation-sites/js/foundation.equalizer.js',
    'bower_components/foundation-sites/js/foundation.interchange.js',
    'bower_components/foundation-sites/js/foundation.magellan.js',
    'bower_components/foundation-sites/js/foundation.offcanvas.js',
    'bower_components/foundation-sites/js/foundation.orbit.js',
    'bower_components/foundation-sites/js/foundation.responsiveMenu.js',
    'bower_components/foundation-sites/js/foundation.responsiveToggle.js',
    'bower_components/foundation-sites/js/foundation.reveal.js',
    'bower_components/foundation-sites/js/foundation.slider.js',
    'bower_components/foundation-sites/js/foundation.sticky.js',
    'bower_components/foundation-sites/js/foundation.tabs.js',
    'bower_components/foundation-sites/js/foundation.toggler.js',
    'bower_components/foundation-sites/js/foundation.tooltip.js',

    // Custom JS files
    'assets/js/vendor/*.js',
    'assets/js/theme/theme.js'
  ]
};

// Delete the "dist" folder
// This happens every time a build starts
gulp.task('clean', function(done) {
  rimraf('dist', done);
});

// Copy Hybrid Core from the bower directory
gulp.task('copy', function() {
  gulp.src(PATHS.hc)
    .pipe(gulp.dest('inc/hybrid-core'));
});

// Compile main stylesheet into CSS
gulp.task('sass', function() {
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
      browsers: COMPATIBILITY
    }))
    .pipe(gulp.dest('./'))
    .pipe($.rename({suffix: '.min'}))
    .pipe($.cleanCss())
    .pipe($.sourcemaps.write('.'))
    .pipe(gulp.dest('./'))
});

// Compile editor stylesheet into CSS
gulp.task('sass:editor', function() {
  return gulp.src('assets/scss/editor-style.scss')
    .pipe($.sass({
      includePaths: PATHS.sass,
    })
    .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: COMPATIBILITY
    }))
    .pipe($.rename({suffix: '.min'}))
    .pipe($.cleanCss())
    .pipe(gulp.dest('assets/css'))
});

// Combine JavaScript into one file and create minified version
gulp.task('javascript', function() {
  return gulp.src(PATHS.javascript)
    .pipe($.babel())
    .pipe($.concat('main.js'))
    .pipe(gulp.dest('assets/js'))
    .pipe($.rename({suffix: '.min'}))
    .pipe($.uglify({mangle: false}))
    .pipe(gulp.dest('assets/js'))
});

// Translates theme files and create a pot file
gulp.task('translate', function() {
  return gulp.src('./**/**.php')
    .pipe($.sort())
    .pipe($.wpPot({
        domain: THEME.current.slug,
        bugReport: pkg.bugReport,
        lastTranslator: pkg.lastTranslator,
        team: pkg.team
    }))
    .pipe(gulp.dest('./languages'));
});

// Build the theme assets
gulp.task('build', function(done) {
  sequence(['copy', 'sass', 'sass:editor', 'javascript'], done);
});

// Replaces all theme specific names with new ones
gulp.task('renametheme', function() {
  return gulp.src(['**/*', '!bower_components/**', '!node_modules/**'])
    .pipe($.replace(THEME.current.name, THEME.new.name))
    .pipe($.replace(THEME.current.slug, THEME.new.slug))
    .pipe($.replace(THEME.current.prefix, THEME.new.prefix))
    .pipe(gulp.dest('./'));
});

gulp.task('dist', ['clean'], function () {
  return gulp.src([
    '**',
    '!node_modules/',
    '!node_modules/**',
    '!bower_components/',
    '!bower_components/**',
    '!assets/scss/',
    '!assets/scss/**',
    '!assets/js/theme/',
    '!assets/js/theme/**',
    '!assets/js/vendor/',
    '!assets/js/vendor/**',
    '!dist/',
    '!dist/**',
    '!.git/**',
    '!bower.json',
    '!package.json',
    '!.gitignore',
    '!.gitmodules',
    '!.tx/**',
    '!**/gulpfile.js',
    '!**/package.json',
    '!**/*~',
    '!*.map'
    ])
  .pipe(gulp.dest('dist/' + pkg.name + '/'));
});

gulp.task('zip', function () {
  return gulp.src('dist/' + pkg.name + '/**')
    .pipe($.zip(pkg.name + '-' + pkg.version + '.zip'))
    .pipe(gulp.dest('dist'));
});

// Build the theme, run the server, and watch for file changes
gulp.task('default', ['build'], function() {
  gulp.watch(['assets/scss/**/*.scss'], ['sass', 'sass:editor']);
  gulp.watch(['assets/js/**/*.js'], ['javascript']);
});
