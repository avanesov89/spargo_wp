/* global exports, require */
'use strict';

const gulp = require('gulp');

// CSS related plugins.
const sass = require('gulp-sass'); // Gulp plugin for Sass compilation
const cleanCss = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer'); // Autoprefixer magic
const postcss = require('gulp-postcss');
const uglify = require('gulp-uglify-es').default;

// Image related plugins.
const imagemin = require("gulp-imagemin");// Minify PNG, JPEG, GIF and SVG images with imagemin.
const svgSprite = require('gulp-svg-sprite');

const babel = require('gulp-babel');
const eslint = require("gulp-eslint");
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');

// Utility related plugins.
const browserSync = require('browser-sync').create();
const merge = require('gulp-merge');
const sourcemaps = require('gulp-sourcemaps');
const livereload = require('gulp-livereload');
const notify = require('gulp-notify'); // Sends message notification to you
const debug = require('gulp-debug');

const dir = {
  src: { //Пути откуда брать исходники
    styles: ['./scss/main.scss', './scss/vendor.scss', './scss/*.scss', './scss/**/*.scss', '!./scss/admin.scss'],
    styles_adm: ['./scss/admin.scss'],
    scripts: {
      vendor: ['./js/vendor/**.js'],
      main: ['./js/global.js', './js/components/**.js', './js/main.js']
    },
    //scripts: ['./js/vendors/*.js', './js/main.js'],
    images: ['./img/*.{jpg,jpeg,png,gif}'],
    icons: ['./img/svg/*.svg'],
    tpl: ['../*.php', '../templates/*.php', '../templates/**/*.php', '../templates/**/**/*.php', '../woocommerce/*.php', '../woocommerce/**/*.php'],
  },
  build: { //Тут мы укажем куда складывать готовые после сборки файлы
    styles: './css/',
    scripts: './js/',
    images: './img/min/'
  }
};

// Оптимизация изображений
function images() {
  return gulp
    .src(dir.src.images)
    .pipe(imagemin({
      progressive: true,
      optimizationLevel: 3, // 0-7 low-high
      interlaced: true,
    }))
    .pipe(gulp.dest(dir.build.images))
    .pipe(notify({ message: 'TASK: "images" 👍', onLast: true }));
}

// Оптимизация иконок
function icons() {
  return gulp
    .src(dir.src.icons)
    .pipe(imagemin({
      svgoPlugins: [{ removeViewBox: false, removeUselessStrokeAndFill: true, removeEmptyAttrs: true }]
    }))
    .pipe(svgSprite({
      mode: {
        stack: {
          sprite: "../sprite.svg"  //sprite file name
        }
      },
    }))
    .pipe(gulp.dest(dir.build.images))
    .pipe(notify({ message: 'TASK: "icons" 👍', onLast: true }));
}

// Стили темы
function styles() {
  return gulp
    .src(dir.src.styles)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer]))
    .pipe(cleanCss({ level: 2 }))
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest(dir.build.styles))
    .pipe(browserSync.stream())
    //.pipe(livereload())
    .pipe(debug({ "title": "styles files" }));
}

function styles_adm() {
  return gulp
    .src(dir.src.styles_adm)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer]))
    .pipe(cleanCss({ compatibility: 'ie8' }))
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest(dir.build.styles))
    .pipe(browserSync.stream())
    //.pipe(livereload())
    .pipe(debug({ "title": "styles files" }));
}

// Проверка скриптов
function scriptsLint() {
  return gulp
    .src(dir.src.scripts)
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

// Скрипты темы
function scripts() {
  return merge(
    gulp.src(dir.src.scripts.vendor)
      .pipe(concat('final_vendor.js'))
      .pipe(gulp.dest(dir.build.scripts))
      .pipe(sourcemaps.init())
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(babel({
        presets: ['@babel/preset-env']
      }))
      .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(dir.build.scripts)),
    gulp.src(dir.src.scripts.main)
      .pipe(concat('final_main.js'))
      .pipe(gulp.dest(dir.build.scripts))
      .pipe(sourcemaps.init())
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(babel({
        presets: ['@babel/preset-env']
      }))
      .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(dir.build.scripts))
  ).pipe(debug({
        "title": "Scripts main files"
  }))
    .pipe(browserSync.stream());
    //.pipe(livereload());
}

function templates() {
  return (
    gulp
      .src(dir.src.tpl)
      .pipe(browserSync.stream())
      //.pipe(livereload())
  );
}

// Слежение за изменением файлов темы
function watchForChanges() {
  //livereload.listen();
  browserSync.init({
    proxy: 'http://spargo.wp.loc/',
    host: 'spargo.wp.loc',
    open: 'external'
  });
  gulp.watch(dir.src.styles, styles);
  gulp.watch(dir.src.styles_adm, styles_adm);
  gulp.watch(dir.src.scripts.vendor, scripts);
  gulp.watch(dir.src.scripts.main, scripts);
  gulp.watch(dir.src.images, images);
  gulp.watch(dir.src.icons, icons);
  gulp.watch(dir.src.tpl, templates);
}

// Определение комплексных задач
const css = gulp.series(styles, styles_adm);
const jsLint = scriptsLint;
const js = scripts;
const dev = gulp.series(gulp.parallel(css, js, images, icons), watchForChanges);
const build = gulp.parallel(css, js, images, icons);
const live = watchForChanges;

// export tasks
exports.css = css;
exports.js = js;
exports.build = build;
exports.live = live;
exports.watch = dev;
exports.default = live;