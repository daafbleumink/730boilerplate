const browsersync = require('browser-sync').create();
const csso = require('gulp-csso');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const postcss = require('gulp-postcss');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const newer = require('gulp-newer');
const purgecss = require('gulp-purgecss');
const rename = require('gulp-rename');

// BrowserSync
function browserSync(done) {
    browsersync.init({
        browser: 'Google Chrome',
        proxy: "localhost/leafspring",
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
            content: ['./header.php', './footer.php', './index.php', './404.php', './single.php', './archive.php', './page-templates/*.php', './page-templates/**/*.php']
        }))
}

// Compile Tailwind + Minifying the output
function css() {

    // Compile Tailwind
    return gulp.src('./src/css/tailwind.css')
        .pipe(postcss([
          require('tailwindcss'),
          require('autoprefixer')
        ]))
        // Storing the complete tailwind.css for fallback purposes
        .pipe(gulp.dest('./dist/css'))
        // Purge CSS
        .pipe(purgecss({ content: [
            './header.php', './footer.php', './index.php', './404.php', './single.php', './archive.php', './page-templates/*.php', './page-templates/**/*.php'
        ] }))
        // Minify CSS
        .pipe(csso())
        // Renaming tailwind.css
        .pipe(rename("style.css"))
        .pipe(gulp.dest('./'))
}
 
// Compress JS
function js(done) {
  destination = './dist/js'
  
  return gulp.src('./src/js/*.js')
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest(destination))
    .pipe(terser())
    .pipe(rename('scripts.min.js'))
    .pipe(gulp.dest(destination))
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
