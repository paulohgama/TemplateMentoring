//REQUIRES
var gulp = require('gulp')
  , autoprefixer = require('gulp-autoprefixer')
  , sass = require('gulp-sass')
  , plumber = require('gulp-plumber')
  , sourcemaps = require('gulp-sourcemaps')
  , imagemin = require('gulp-imagemin')
  , beautifycss = require('gulp-cssbeautify')
  , uglifyjs = require('gulp-uglify')
  , concat = require('gulp-concat')
  , cssmin = require('gulp-cssmin')
  , htmlclean = require('gulp-htmlclean')
  , gutil = require('gulp-util')
  , rename = require('gulp-rename')
  , cssnano = require('gulp-cssnano')
  , browserSync = require('browser-sync').create()
  , reload = browserSync.reload

//PATHS FILES
var paths = {
  src: {
    basePath: 'resources/assets/**/*',
    //html: 'resources/assets/html/**/*',
    sass: 'resources/assets/scss/**/*.scss',
    sass_admin: 'resources/assets/scss_admin/**/*.scss',
    js: 'resources/assets/js/**/*.js',
    js_admin: 'resources/assets/js_admin/**/*.js',
    img: 'resources/assets/images/**/*',
    fonts: ['node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'resources/assets/fonts/']
  },
  dest: {
    //html: 'resources/views/',
    sass: 'public/css',
    sass_admin: 'public/css/admin',
    js: 'public/js',
    js_admin: 'public/js/admin',
    img: 'public/images',
    beauty: {
      sass: 'public/css/beauty',
      sass_admin: 'public/css/admin/beauty'
    },
    fonts: 'public/fonts/'
  }
};
//ASSETS
var assets = {
  js: [
    //"node_modules/jquery/dist/jquery.js",
    //"node_modules/slick-carousel/slick/slick.js",
    //"node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js",   
    "node_modules/jquery-bar-rating/dist/jquery.barrating.min.js"
  ],
  css: [
    //"node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css",
    //"node_modules/slick-carousel/slick/slick.scss",
    //"node_modules/jssocials/dist/jssocials.css",
    //"node_modules/jssocials/dist/jssocials-theme-flat.css",
    "node_modules/jquery-bar-rating/dist/themes/fontawesome-stars.css"
  ]
}
//TASKS
gulp.task('imagemin', function () {
  gulp.src(paths.src.img)
    .pipe(imagemin())
    .pipe(gulp.dest(paths.dest.img));   
});

// Style SASS & Autoprefixer Min
gulp.task('scss', function () {
  gulp.src(paths.src.sass)
    .pipe(plumber())
    .pipe(sass())
    .pipe(autoprefixer({
      browsers: ['last 30 versions'],
      cascade: false
    }))
    .pipe(cssmin())
    .pipe(plumber.stop())
    .pipe(rename('style.min.css'))
    .pipe(gulp.dest(paths.dest.sass))
    .pipe(beautifycss())
    .pipe(gulp.dest(paths.dest.beauty.sass));
});

gulp.task('scss_admin', function () {
	gulp.src(paths.src.sass_admin)
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}).on('error', sass.logError))
		.pipe(sourcemaps.write())
		.pipe(autoprefixer({
			browers: ['last 10 versions'],
			cascade: false
		}))
		.pipe(rename({
			extname: ".min.css"
		}))
		.pipe(gulp.dest(paths.dest.sass_admin))
});

gulp.task('js_admin', function () {
  gulp.src(paths.src.js_admin)
    .pipe(sourcemaps.init())
    .pipe(uglifyjs().on('error', gutil.log))
    .pipe(sourcemaps.write())
    .pipe(rename(function (file) {
      file.extname = ".min.js";
    }))
    .pipe(gulp.dest(paths.dest.js_admin));
});

gulp.task('js', function () {
    gulp.src(paths.src.js)
      .pipe(sourcemaps.init())
      .pipe(uglifyjs().on('error', gutil.log))
      .pipe(sourcemaps.write())
      .pipe(rename(function (file) {
        file.extname = ".min.js";
      }))
      .pipe(gulp.dest(paths.dest.js));
  });

// Font task
gulp.task('fonts', () => {
  return gulp.src(paths.src.fonts.map((index) => {
    return index + '**/*.{eot,svg,ttf,woff,woff2}'
  }))
    .pipe(gulp.dest(paths.dest.fonts));
});

gulp.task('videos', () => {
  return gulp.src('resources/assets/videos/**/*')
    .pipe(gulp.dest('public/videos'));
});

gulp.task('vendor-scripts', () => {
  return gulp.src(assets.js.map((x) => {
    return x
  }))
    .pipe(concat('vendor.js'))
    .pipe(uglifyjs({ compress: { drop_console: true } }))
    .pipe(gulp.dest('public/js/'));
});

gulp.task('vendor-styles', () => {
  return gulp.src(assets.css.map((x) => {
    return x
  }))
    .pipe(plumber())
    .pipe(sass())
    .pipe(concat('vendor.css'))
    .pipe(cssnano({ safe: true, autoprefixer: false }))
    .pipe(gulp.dest('public/css'));
});

gulp.task('watch', function () {
  gulp.watch(paths.src.sass, ['scss']);  
  gulp.watch(paths.src.sass_admin, ['scss_admin']);
  gulp.watch(paths.src.js, ['js']);
  gulp.watch(paths.src.js_admin, ['js_admin']);
  gulp.watch(paths.src.img, ['imagemin']);
  gulp.watch(paths.src.fonts, ['fonts']);
});

gulp.task('serve', ['scss','scss_admin', 'js', 'js_admin', 'vendor-scripts', 'vendor-styles', 'imagemin', 'videos', 'fonts', 'watch'], function () {
  browserSync.init({
    notify: false,    
    proxy: '127.0.0.1:8000',
    files: [
      paths.src.sass,   
    ]
  })    
  gulp.watch([paths.dest.sass], function(){
    reload;
  });
  //gulp.watch([paths.dest.sass],['scss']);
});


gulp.task('default', ['scss','scss_admin', 'js', 'js_admin', 'vendor-scripts', 'vendor-styles', 'imagemin', 'videos', 'fonts', 'watch']);