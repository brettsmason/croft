var $        = require('gulp-load-plugins')();
var pkg      = require('./package.json');
var gulp     = require('gulp');
var rimraf   = require('rimraf');
var sequence = require('run-sequence');

// Browsers to target when prefixing CSS.
var COMPATIBILITY = [
  'last 2 versions',
  'ie >= 9',
  'Android >= 2.3'
];

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
    'node_modules/hybrid-core/**'
  ],
  sass: [
    'node_modules/foundation-sites/scss',
    'node_modules/motion-ui/src'
  ],
  javascript: [
    // What-input
    'node_modules/what-input/what-input.js',

    // Foundation Core and utils
    'node_modules/foundation-sites/js/foundation.core.js',
    'node_modules/foundation-sites/js/foundation.util.*.js',

    // Individual Foundation JS components
    'node_modules/foundation-sites/dist/js/plugins/foundation.abide.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.accordion.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.accordionMenu.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.drilldown.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.dropdown.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.dropdownMenu.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.equalizer.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.interchange.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.magellan.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.offcanvas.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.orbit.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.responsiveAccordionTabs.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.responsiveMenu.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.responsiveToggle.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.reveal.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.slider.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.smoothScroll.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.sticky.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.tabs.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.toggler.js',
    'node_modules/foundation-sites/dist/js/plugins/foundation.tooltip.js',

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
  sequence(['sass', 'sass:editor', 'javascript'], done);
});

// Replaces all theme specific names with new ones
gulp.task('renametheme', function() {
  return gulp.src(['**/*', '!node_modules/**'])
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
    '!assets/scss/',
    '!assets/scss/**',
    '!assets/js/theme/',
    '!assets/js/theme/**',
    '!assets/js/vendor/',
    '!assets/js/vendor/**',
    '!dist/',
    '!dist/**',
    '!.git/**',
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
  gulp.watch(['assets/js/theme/**/*.js', 'assets/js/vendor/**/*.js'], ['javascript']);
});
