var gulp 		 = require('gulp'),
	sass 		 = require('gulp-sass'),   // Подключаем SASS
	browserSync  = require('browser-sync'), // Подключаем Browser Sync
	concat       = require('gulp-concat'), // Подключаем gulp-concat (для слияния файлов)
    uglify       = require('gulp-uglify-es').default, // Подключаем плагин для сжатия JS
    jsRequires   = require('gulp-resolve-dependencies'), // Подключаем пакет для импортирования скриптов через //@requires *.js
    postcss      = require("gulp-postcss"),
    cssImport    = require('postcss-import'),   // Подключаем пакет для импортирования кода css, прописанного через @import '*.css' 
    //mqpacker     = require('css-mqpacker'),	// Подключаем пакет для поиска одинаковых медиа запросов и объединение их в один
    cleanCSS     = require('gulp-clean-css'), // Подключаем пакет для минификации CSS с объединением одинаковых медиа запросов
    sourcemaps   = require('gulp-sourcemaps'), // Подключаем пакет sourcemaps для нахождения исходных стилей и скриптов в режиме dev-tool браузера
    rename       = require('gulp-rename'), // Подключаем библиотеку для переименования файлов
	clean 		 = require('gulp-clean'), // Подключаем библиотеку для удаления файлов и папки build перед новой выгрузкой проекта
    //imagemin     = require('imagemin'), // Подключаем библиотеку для работы с изображениями
    //imgCompress  = require('imagemin-jpeg-recompress'), // Подключаем библиотеку для работы с изображениями
    //pngquant     = require('imagemin-pngquant'), // Подключаем библиотеку для работы с png
    cache        = require('gulp-cache'), // Подключаем библиотеку кеширования изображений
    autoprefixer = require('gulp-autoprefixer');// Подключаем библиотеку для автоматического добавления префиксов

var path = {
        src: 'src/',
        html: 'wp-content/themes/mytheme-child/'
}

gulp.task('message', async function() { //без async вывод будет считаться синхронным и ждать завершения. Это стало с версии 4.0
	console.log('Console message');
});


gulp.task('styles', function() { // таск 'styles' обработает все файлы *.sass, вложенные в любые подпапки, кроме libs.sass
	return gulp.src(
        [
            path.src+'sass/**/*.sass',
            //'!'+path.src+'sass/vendors.sass'
        ])
		// gulp.src('src/sass/*.+(sass|scss)')
		// gulp.src(['src/sass/**/*.sass','!src/sass/libs.sass'])  ! - кроме styles.sass
        //.pipe(sourcemaps.init()) //инициализируем soucemap
		.pipe(sass({ outputStyle: 'expanded' })) // Функция преобразования SASS в CSS. { outputStyle: 'expanded' } развертывает все унификации
        .pipe(concat('main.css')) // Объединяем все найденные файлы в один
        .pipe(autoprefixer({
            grid: true,
            overrideBrowserslist: ['last 2 versions']
        })) // Создаем префиксы
        //.pipe(cleanCSS({level:2})) // Сжимаем css и объединяет импортируемые стили @import
        //.pipe(sourcemaps.write()) //пропишем sourcemap
		.pipe(gulp.dest(path.src+'css')) // Выгружаем результат в папку src/css
		/*
			файлы с подчеркиванием не учавтсвуют в компиляции, например, _part.sass. 
			Его подключают через @import 'part' в файле *.sass 
		*/
		.pipe(browserSync.stream()); // Обновляем CSS на странице при изменении
});

gulp.task('vendors-styles', function() { // таск обработает все файлы *.css, вложенные в любые подпапки, кроме libs.sass
    return gulp.src(
        [
            path.src+'css/**/*.css', 
            '!'+path.src+'css/main.css',
            '!'+path.src+'css/*.min.css',
		])
        .pipe(postcss([ cssImport ]))
        .pipe(concat('vendors.min.css')) // Объединяем все найденные файлы в один
        .pipe(cleanCSS({level:2})) // Сжимаем css и объединяет импортируемые стили @import
        .pipe(gulp.dest(path.src+'css')) // Выгружаем результат в папку src/css
});

gulp.task('scripts', function() {
    return gulp.src([path.src+'js/custom.js'])
    //.pipe(sourcemaps.init()) // Инициализируем sourcemap
    .pipe(concat('custom.min.js')) // Объединяем в один файл
    .pipe(uglify()) // Minify js (opt.)
    //.pipe(sourcemaps.write()) // Пропишем карты
    .pipe(gulp.dest(path.src+'js')) // Выгружаем в папку src/js
	.pipe(browserSync.reload({ stream: true }))  // Обновляем страницу после изменения своего скрипта
});

// Запускается тогда, когда добавляются сторонние скрипты и формируется общий файл libs.min.js
gulp.task('vendors-scripts', function() {
    return gulp.src([ // Берем нужные библиотеки вендорных скриптов
        //'node_modules/jquery/dist/jquery.min.js', // jQuery plug-in (npm i --save-dev jquery)
        path.src+'js/*.js', // Vendors scripts.
        '!'+path.src+'js/custom*.js'
    ])
    .pipe(jsRequires({ // подключаем внешние скрипты, если они прописаны в заголовке файлов через @requires
      pattern: /\* @requires [\s-]*(.*\.js)/g
        }))
        .on('error', function(err) {
            console.log(err.message);
        })
    .pipe(concat('vendors.min.js')) // Объединяем в один файл
    .pipe(uglify()) // Сжимаем JS файл
	.pipe(gulp.dest(path.src+'js')) // Выгружаем в папку src/js
	//.pipe(browserSync.reload({ stream: true }))
});

gulp.task('img', function() {
    return gulp.src(path.src+'img/**/*.+(jpg|png)') // Берем все изображения из src
	    .pipe(imagemin([
	    	imgCompress({
	    		loops: 4,
	    		min: 80,
	    		max: 90,
	    		quality: 'high'
	    	}),
	    	imagemin.gifsicle(),
	    	imagemin.optipng(),
	    	imagemin.svgo()
	    	]))
        .pipe(gulp.dest('img/')); // Выгружаем на продакшен
});

gulp.task('html', function() {
    return gulp.src([path.html+'**/*.html', path.html+'**/*.php'])
        .pipe(browserSync.reload({ stream: true }))
});

gulp.task('browser-sync', function() { // Создаем таск browser-sync
    browserSync({ // Выполняем browser Sync
        server: { // Определяем параметры сервера
            baseDir: 'src' // Директория для сервера - src
        },
        notify: false, // Отключаем уведомления
        online: false, // Work offline without internet connection
        // tunnel: true, tunnel: 'projectname', // Demonstration page: http://projectname.localtunnel.me
    });
});

gulp.task('watch', function() { //таск слежения изменений в Sass,html,php,js. 
	//Чтобы отслеживать изменения на сайте, выполните таск 'sync'
    gulp.watch([path.src+'sass/**/*.sass'], gulp.parallel('styles')); // Наблюдение за sass файлами в папке sass
    gulp.watch([path.src+'css/**/*.css', '!'+path.src+'css/main.css'], gulp.parallel('vendors-styles')); // Наблюдение за вендорными css файлами в папке _src
    gulp.watch([path.src+'js/custom.js'], gulp.parallel('scripts')); // Наблюдение за главным JS файлом
    gulp.watch([path.src+'js/*.js', '!'+path.src+'js/custom*.js'], gulp.parallel('vendors-scripts')); // Наблюдение за сторонней библиотекой JS файлов
    gulp.watch([path.html+'**/*.html', path.html+'**/*.php'], gulp.parallel('html')); // Наблюдение за HTML файлами в корне проекта
});

gulp.task('css-compress', async function() {
    var buildCss =  gulp.src(path.src+'css/main.css') // Сжимаем библиотеки
    .pipe(cleanCSS({level:2})) // Сжимаем CSS файл
    .pipe(rename({suffix: '.min'})) // Добавляем суффикс .min
    .pipe(gulp.dest(path.src+'css'))
});

//Чистка кэша. Запускается при необходимости
gulp.task('clean-cache', function (callback) {
    return cache.clearAll();
})

gulp.task('clean-build-folder', async function() { // Удаляем папку build перед сборкой
    return gulp.src('build/*.*', {read: false})
        .pipe(clean());
});

// Deploy выгрузка готового сайта на хостинг
gulp.task('rsync', function() {
    return gulp.src(path.src+'')
    .pipe(rsync({
        root: path.src,
        hostname: 'username@yousite.com',
        destination: 'yousite/public_html/',
        // include: ['*.htaccess'], // Included files
        exclude: ['**/Thumbs.db', '**/*.DS_Store'], // Excluded files
        recursive: true,
        archive: true,
        silent: false,
        compress: true
    }))
});

//Дефолтный таск для запуска процессов слежения за изменениями кода. Выполняется командой Gulp без параметров
gulp.task('default', gulp.parallel('styles', 'scripts', 'vendors-scripts', 'browser-sync', 'watch'));//'img'


