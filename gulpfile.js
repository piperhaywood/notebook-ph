var gulp         = require('gulp');
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
    .pipe(concat('styles.css'))
    .on('end', function() { gutil.log(themeDir); })
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
    'js/scripts.js',
  ])
    .pipe(sourcemaps.init())
    .pipe(concat('scripts.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(themeDir));
});

gulp.task('build', ['sass', 'js', 'fonts']);

