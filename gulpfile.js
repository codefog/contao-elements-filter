'use strict';

const gulp = require('gulp');
const rename = require('gulp-rename');
const uglify = require('gulp-uglify');

// Configuration
const scripts = [
    'assets/handler/handler.js'
];

// Compress the scripts
gulp.task('compress', function () {
    return gulp.src(scripts, {base: './'})
        .pipe(uglify())
        .pipe(rename(function (path) {
            path.extname = '.min' + path.extname;
        }))
        .pipe(gulp.dest('./'));
});

// Copy the Isotope
gulp.task('isotope', function () {
    return gulp.src(['node_modules/isotope-layout/dist/*'], {base: 'node_modules/isotope-layout/dist'})
        .pipe(gulp.dest('assets/isotope'));
});

// Build by default
gulp.task('default', ['compress', 'isotope']);
