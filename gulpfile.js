var gulp         = require('gulp');
var browserSync  = require('browser-sync').create();
var gutil        = require('gulp-util');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps   = require('gulp-sourcemaps');
var cssmin       = require('gulp-cssmin');
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');
var addsrc       = require('gulp-add-src');
var header       = require('gulp-header');

var pkg = require('./package.json');
var banner = ['/**',
  ' * Theme Name: <%= pkg.title %>',
  ' * Author: <%= pkg.author.name %>',
  ' * Author URI: <%= pkg.author.url %>',
  ' * Description: <%= pkg.description %>',
  ' * Version: <%= pkg.version %>',
  ' * License: <%= pkg.license %>',
  ' * Textdomain: <%= pkg.name %>',
  ' */',
  '',].join('\n');

var themeDir = 'wp-content/themes/' + pkg.name + '/';

gulp.task('sass', function() {
  return gulp.src('css/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(sourcemaps.write())
    .pipe(autoprefixer())
    .pipe(concat('style.css'))
    .pipe(cssmin())
    .pipe(header(banner, { pkg: pkg }))
    .pipe(gulp.dest(themeDir));
});

gulp.task('fonts', function() {
  return gulp.src('fonts/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(sourcemaps.write())
    .pipe(autoprefixer())
    .pipe(concat('fonts.css'))
    .pipe(cssmin())
    .pipe(gulp.dest(themeDir));
});

gulp.task('js', function() {
  return gulp.src([
    'bower_components/jquery/dist/jquery.js',
    'bower_components/jquery.fitvids/jquery.fitvids.js',
    'bower_components/prism/prism.js',
    'js/scripts.js',
  ])
    .pipe(sourcemaps.init())
    .pipe(concat('scripts.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(themeDir));
});

gulp.task('customizer', function() {
  return gulp.src([
    'js/customizer.js',
  ])
    .pipe(sourcemaps.init())
    .pipe(concat('customizer.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(themeDir));
});

gulp.task('browserSync', function() {
  browserSync.init({
    ghostMode: false,
    open: true,
    notify: false,
    proxy: 'localhost:8888/pipers-notes',
  });
});

gulp.task('default', ['sass', 'js', 'fonts', 'customizer']);

gulp.task('watch', ['default', 'browserSync'], function() {
  gulp.watch('css/**/*.scss', ['sass']);
  gulp.watch('js/scripts.js', ['js']);
  gulp.watch('fonts/**/*.scss', ['fonts']);
  gulp.watch('js/customizer.js', ['customizer']);
  gulp.watch(themeDir + '**/*').on('change', browserSync.reload);
});
