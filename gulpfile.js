const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const less = require('gulp-less');
const del = require('del');

let DIR = {
    less: './assets/less',
    build: './public/build'
};

DIR.build_css = `${DIR.build}/css`;
DIR.build_js = `${DIR.build}/js`;

gulp.task('browser-sync', function(){
   browserSync.init({
        proxy: "localhost:8000",
        files: [
            "src/**/**.php",
            "public/index.php",
            "templates/**/*.phtml",
            `${DIR.build_css}/**/*.css`
        ]
   })
});

gulp.task('clean', function(){
   del.sync([DIR.build]);
});

gulp.task('less', function(){
    gulp.src(`${DIR.less}/style.less`)
        .pipe(less())
        .pipe(gulp.dest(DIR.build_css));
});

gulp.task('scripts', function(){
    gulp.src([
        './node_modules/jquery/dist/jquery.min.js',
        './node_modules/bootstrap/dist/js/bootstrap.min.js'
    ]).pipe(gulp.dest(DIR.build_js))
});

gulp.task('watch', function(){
   gulp.watch([`${DIR.less}/**/*.less`], ['less']);
});

gulp.task('dev', ['clean','watch','scripts','less', 'browser-sync']);