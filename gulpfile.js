var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var postcss = require('gulp-postcss');
var image = require('gulp-image');
var tailwindcss = require('tailwindcss');
var csso = require('gulp-csso');


var browserSync = require('browser-sync').create();
var reload = browserSync.reload;

// Watch Paths
var styleWatch = './src/scss/**/*.scss';
var jsWatch = './src/scss/**/*.scss';
var styleWatch = './src/scss/**/*.scss';

// Stating browserSync options
var browserSyncOptions = {
    browser: "chrome",
    port: '80',
    proxy: "localhost/test",
    notify: false
};

// Browsersync
function browser_sync(done) {

    browserSync.init(browserSyncOptions);

    done();

};

// Compile Tailwind + Minifying the output
function css(done) {

    // Compile Tailwind
    return gulp.src('./src/scss/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([
            tailwindcss('./tailwind.js'),
            require('autoprefixer'),
        ]))
        .pipe(gulp.dest('./src/scss')) 
        
        // Minify the file
        .pipe(csso())
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream());
        done();
};
 
// Optimize images
function image(done) {
  gulp.src('./src/img/*')
    .pipe(image())
    .pipe(gulp.dest('./dist/img'));
    done();
};

// Compress JS
function js(done) {
    gulp.src('./src/js/*.js')
    .pipe(uglify())
    .pipe(gulp.dest('./dist/js'));
    done();
};


function watch_files() {
    gulp.watch(styleWatch, css);
    gulp.watch(jsWatch, gulp.series(js, reload));
};

gulp.task("css", css);

gulp.task("js", js);

gulp.task("browser-sync", browser_sync);

gulp.task("image", image);

gulp.task("default", gulp.series(image, css, js, browser_sync));

gulp.task("watch", gulp.series(watch_files, browser_sync));
