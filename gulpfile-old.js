var $        = require('gulp-load-plugins')();
var pkg      = require('./package.json');
var gulp     = require('gulp');
var rimraf   = require('rimraf');
var sequence = require('run-sequence');

// Load our config.yml file
function loadConfig() {
  let ymlFile = fs.readFileSync('config.yml', 'utf8');
  return yaml.load(ymlFile);
}

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
        domain: POT.slug,
        bugReport: POT.bugReport,
        lastTranslator: POT.lastTranslator,
        team: POT.team
    }))
    .pipe(gulp.dest('./languages'));
});

// Build the theme assets
gulp.task('build', function(done) {
  sequence(['sass', 'sass:editor', 'javascript'], done);
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
  .pipe(gulp.dest('dist/' + THEME.current.slug + '/'));
});

gulp.task('zip', function () {
  return gulp.src('dist/' + THEME.current.slug + '/**')
    .pipe($.zip(THEME.current.slug + '-' + pkg.version + '.zip'))
    .pipe(gulp.dest('dist'));
});

// Build the theme, run the server, and watch for file changes
gulp.task('default', ['build'], function() {
  gulp.watch(['assets/scss/**/*.scss'], ['sass', 'sass:editor']);
  gulp.watch(['assets/js/theme/**/*.js', 'assets/js/vendor/**/*.js'], ['javascript']);
});


// Clone Hybrid Core and remove the .git folder
gulp.task('hybrid-core', function(done) {
  git.clone('https://github.com/justintadlock/hybrid-core', {args: './inc/hybrid-core'}, function(err) {
    if (err) throw err;
  });
  rimraf('./inc/hybrid-core/.git', done);
})