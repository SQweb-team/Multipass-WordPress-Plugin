'use strict';

let gulp = require('gulp');
let jshint = require('gulp-jshint');
let nano = require('gulp-cssnano');
let sequence = require('gulp-sequence');
let zip = require('gulp-zip');
let del = require('del');
let autoprefixer = require('gulp-autoprefixer');
let stylelint = require('gulp-stylelint');

gulp.task('jshint', () => gulp
    .src('src/resources/js/*.js')
    .pipe(jshint(__dirname + '/../SQweb-Coding-Style/js/.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'))
);

gulp.task('css-lint', () => gulp
  .src('src/resources/css/*.css')
  .pipe(stylelint({
    reporters: [
      {
        formatter: 'verbose',
        console: true
      },
    ],
    configFile: __dirname + '/../SQweb-Coding-Style/css/stylelint.config.js',
    debug: true
  }))
);

gulp.task('css-minify', () => gulp
  .src('./build/sqweb-wordpress-plugin/resources/css/*.css')
  .pipe(autoprefixer({
    browsers: ['last 2 versions'],
    cascade: false
  }))
  .pipe(nano())
  .pipe(gulp.dest('./build/sqweb-wordpress-plugin/resources/css'))
);

gulp.task('copy', () => gulp
  .src(['./src/**/*'])
  .pipe(gulp.dest('build/sqweb-wordpress-plugin'))
);

gulp.task('cleanup', () => {
  const base = 'build/sqweb-wordpress-plugin';
  return del([base + '/phpunit.xml', base + '/bin', base + '/tests']);
});

gulp.task('zip', () => gulp
  .src(['./build/sqweb-wordpress-plugin/**/*'], {base : "./build"})
  .pipe(zip('sqweb-wordpress-plugin.zip'))
  .pipe(gulp.dest('dist'))
);

gulp.task('clean', () => del(['build/']));

gulp.task('keep-build', sequence('jshint', 'css-lint', 'copy', 'css-minify', 'zip'));

gulp.task('default', sequence('jshint', 'css-lint', 'copy', 'css-minify', 'cleanup', 'zip', 'clean'));
