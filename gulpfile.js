const autoprefixer = require('gulp-autoprefixer');
const browsersync = require('browser-sync').create();
const csso = require('gulp-csso');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const purgecss = require('gulp-purgecss')
const postcss = require('gulp-postcss');
const uglify = require('gulp-uglify');
const newer = require('gulp-newer');
const tailwindcss = require('tailwindcss');
const rename = require('gulp-rename');

// BrowserSync
function browserSync(done) {
    browsersync.init({
        browser: 'firefox',
        proxy: "localhost/730v3",
        notify: false
    });
    done();
  }
  
  // BrowserSync Reload
  function browserSyncReload(done) {
    browsersync.reload();
    done();
  }

  // Optimize Images
function images() {
    return gulp
      .src("./src/img/*")
      .pipe(newer("./dist/img"))
      .pipe(
        imagemin([
          imagemin.gifsicle({ interlaced: true }),
          imagemin.jpegtran({ progressive: true }),
          imagemin.optipng({ optimizationLevel: 5 }),
          imagemin.svgo({
            plugins: [
              {
                removeViewBox: false,
                collapseGroups: true
              }
            ]
          })
        ])
      )
      .pipe(gulp.dest("./dist/img"));
    }

// Purge CSS
function purgeCSS() {
  return gulp.src('./dist/css/tailwind.css')
        .pipe(purgecss({
            content: ['./*.php']
        }))
}

// Compile Tailwind + Minifying the output
function css() {

    // Compile Tailwind
    return gulp.src('./src/css/tailwind.css')
        .pipe(postcss([
            tailwindcss('./tailwind.config.js'),
        ]))
        // Supporting all browsers
        .pipe(autoprefixer())
        // Storing the complete tailwind.css for fallback purposes
        .pipe(gulp.dest('./dist/css'))
        // PurgeCSS
        .pipe(purgeCSS())
        // Minify CSS
        .pipe(csso())
        // Renaming tailwind.css
        .pipe(rename("style.css"))
        .pipe(gulp.dest('./'))
    }
 
// Compress JS
function js(done) {
    gulp.src('./src/js/*.js')
    .pipe(uglify())
    .pipe(gulp.dest('./dist/js'))
    done()
    }

// Watch files
function watchFiles() {
    gulp.watch("./src/css/*", css);
    gulp.watch("./src/js/*", js);
    gulp.watch(      
        [
        "./*.php",
        "./page-templates/*.php",
        "./page-templates/components/*.php",
      ],
      browserSyncReload
    );
    gulp.watch("./src/img/*", images);
    }

// Define complex tasks
const compile = gulp.series(css, js, images);
const watch = gulp.parallel(watchFiles, browserSync);

// Export tasks
exports.purgecss = purgeCSS;
exports.css     = css;
exports.images  = images;
exports.js      = js;
exports.watch   = watch;
exports.default = compile;
