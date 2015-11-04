var gulp = require('gulp'),
    cssbeautify = require('gulp-cssbeautify'),
    cssmini = require('gulp-clean-css'),
    sequence = require('gulp-sequence'),
    zip = require('gulp-zip'),
    del = require('del');

gulp.task('css-beaut', function() {
  return gulp.src('./src/resources/css/*.css')
    .pipe(cssbeautify({
      indent: '    ',
      openbrace: 'end-of-line',
      autosemicolon: true
    }))
    .pipe(gulp.dest('./src/resources/css'));
});

gulp.task('copy', function() {
  return gulp.src(['./src/**/*'])
    .pipe(gulp.dest('build/sqweb-wordpress-plugin'));
});

gulp.task('minify-css', function() {
  return gulp.src('./build/sqweb-wordpress-plugin/resources/css/*.css')
    .pipe(cssmini())
    .pipe(gulp.dest('./build/sqweb-wordpress-plugin/resources/css'))
});

gulp.task('zip', function() {
  return gulp.src(['./build/sqweb-wordpress-plugin/**/*'], {base : "./build"})
    .pipe(zip('sqweb-wordpress-plugin.zip'))
    .pipe(gulp.dest('dist'));
});

gulp.task('clean', function() {
  return del(['build/']);
});

gulp.task('keep-build', sequence('copy', 'minify-css', 'zip'));

gulp.task('default', sequence('copy', 'minify-css', 'zip', 'clean'));