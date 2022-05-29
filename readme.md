# Инструкция по разворачиванию проекта Интерьер-West на Wordpress

<p>Автор: <b>Станислав Шабалин</b></p>

<p><b>В проект входят:</b>
<div><b>resources</b> - папка для сбора и хранения исходных данных заказчика (ТЗ, макеты, примеры и тд)</div>
<div><b>src/</b> - рабочаяя папка проекта для разработки</div>
<div><b>src/css</b> - исходные подключаемые стили сторонних плагинов</div>
<div><b>src/js</b> - свои кастомные и сторонние скрипты</div>
<div><b>src/fonts</b> - исходные шрифты для подключения в main.css</div>
<div><b>src/sass</b> - исходные собственные стили для препроцессора sass. Компилируются в main.css</div>
<div><b>src/img</b> - исходные изображения (например, логотипы и тп, которые не войдут в media библиотеку WP)</div>
<div><b>src/plugins</b> - библиотеки сторонних разработчиков (подключаются, например, в css/vendors.css и js/_vendors.js файлах)</div>
<div><b>src/worpdress</b> - папка Worpress</div>
<div><b>src/wp-content/</b> - папка контента для Worpress (вынесена из стандартного размещения внутри Worpdress)</div>
<div><b>src/wp-content/themes/starck-theme/</b> - папка с подключенной дочерней темой (functions.php, style.css)</div>
<div><b>src/wp-content/themes/starck-theme/inc</b> - внутренние файлы для создания темы</div>
<div><b>src/wp-content/themes/starck-theme/css</b> - папка с подключаемыми стилями (main.min.css, vendors.min.css)</div>
<div><b>src/wp-content/themes/starck-theme/js</b> - папка с подключаемыми скриптами (custom.min.js, vendors.min.js)</div>
<div><b>src/wp-content/themes/starck-theme/img</b> - папка с подключаемыми изображениями</div>
<div><b>src/wp-content/themes/starck-theme/fonts</b> - папка с подключаемыми шрифтами</div>
<div><b>src/wp-config.php</b> - файл для подключения БД настроек структуры Wordpress</div>
<div><b>src/index.php</b> - продублированный стартовый файл из папки wordpress с измененными настройками</div>
<div><b><i>wp-install.js</i></b> - скрипт для установки последней версии CMS WordPress (rus)</div>
<div><b><i>gulpfile.js</i></b> - скрипты gulp для работы с проектом</div>
</p>


## Запуск проекта

### Основные таски Gulp для работы с проектом:

<ul>
	<li><b title="gulp styles"><em>gulp styles</em></b>: конвертирует все файлы sass в css/main.css</li>
	<li><b title="gulp vendors-styles"><em>gulp vendors-styles</em></b>: подключает сторонние css файлы, включая стили, прописанные через @import в файле css/_vendors.css</li>
	<li><b title="gulp scripts"><em>gulp scripts</em></b>: объединяет собственные скрипты c именем *custom* в файл custom.min.js и сжимает их</li>
	<li><b title="gulp vendors-scripts"><em>gulp vendors-scripts</em></b>: объединяет все сторонние скрипты в папке js, кроме *custom*.js и сжимает их, записывая в файл js/vendors.min.js</li>
	<li><b title="gulp css-compress"><em>gulp css-compress</em></b>: сжатие своих стилей в файл css/main.min.css</li>
	<li><b title="gulp rsync"><em>gulp rsync</em></b>: выгрузка проекта на удаленный сервер хостера</li>
	<li><b title="gulp [default]"><em>gulp</em></b>: запуск группы тасков ['styles', 'scripts', 'vendors-scripts', 'browser-sync', 'watch'] для работы с проектом</li>
</ul>
