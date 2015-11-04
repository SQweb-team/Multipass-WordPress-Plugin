var gulp = require('gulp'),
    cssbeautify = require('gulp-cssbeautify'),
    cssmini = require('gulp-clean-css'),
    sequence = require('gulp-sequence');

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
    .pipe(gulp.dest('build'));
});

gulp.task('minify-css', function() {
  return gulp.src('./build/resources/css/*.css')
    .pipe(cssmini())
    .pipe(gulp.dest('./build/resources/css'))
});

gulp.task('default', sequence('copy', 'minify-css'));