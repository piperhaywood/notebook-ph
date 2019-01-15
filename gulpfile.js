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

gulp.task('js', function() {
  return gulp.src([
    'node_modules/infinite-scroll/dist/infinite-scroll.pkgd.js',
    'node_modules/prismjs/prism.js',
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

gulp.task('watch', function(done) {
  gulp.watch('css/**/*.scss', gulp.series('sass'));
  gulp.watch('js/scripts.js', gulp.series('js'));
  gulp.watch('js/customizer.js', gulp.series('customizer'));
  gulp.watch(themeDir + '**/*').on('change', browserSync.reload);
  done();
});

gulp.task('browserSync', function(done) {
  browserSync.init({
    ghostMode: false,
    open: true,
    notify: false,
    proxy: 'localhost:8888/notebook-ph',
  });
  done();
});

gulp.task('dev', gulp.parallel('sass', 'js', 'customizer'));
gulp.task('default', gulp.series('dev', gulp.parallel('watch', 'browserSync')));
