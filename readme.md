<h1>Инструкция по разворачиванию нового проекта на Wordpress с Gulp</h1>
<p>(HTML-Template 1 версия)</p>

<p>Автор: <b>Starck</b></p>

<p>За основу был взят шаблон <a href="http://github.com/agragregra/oh5">OptimizedHTML 5</a></p>

<p><b>В пакет входят:</b> 
<li><b>src</b> - рабочаяя папка проекта для разработки</li>
<li><b>resource</b> - папка для сбора и хранения исходных данных заказчика (ТЗ, макеты, примеры и тд)</li>
<li><b><i>gulpfile.js</i></b> - скрипты для gulp</li>
<li><b><i>package.json</i></b> - собранный установочный пакет необходимых для gulp скриптов</li>

</p>
<h2>Запуск проекта</h2>

<pre>git clone https://github.com/Starck43/Start-GWP-Template.git</pre>

<ol>
	<li>Клонировать или <a href="https://github.com/Starck43/Start-GWP-Template/archive/master.zip">скачать</a> <b>стартовый шаблон</b> с GitHub. Для клонирования должен быть установлен Git.</li>
	<li><b>npm i</b> - установить плагины в node_modules для нового проекта (запускать в корне проекта через консоль с предустановленным Node.js и глобальным Gulp</li>
	<li><b>gulp</b> - запуск Gulp</li>
</ol>

<h2>Основные скрипты Gulp для работы с проектом:</h2>

<ul>
	<li><b title="gulp styles"><em>gulp styles</em></b>: конвертирует все файлы sass в css/main.css</li>
	<li><b title="gulp vendors-styles"><em>gulp vendors-styles</em></b>: подключает сторонние css файлы, включая стили, прописанные через @import в файле css/_vendors.css</li>
	<li><b title="gulp scripts"><em>gulp scripts</em></b>: объединяет собственные скрипты c именем *custom* в файл custom.min.js и сжимает их</li>
	<li><b title="gulp vendors-scripts"><em>gulp vendors-scripts</em></b>: объединяет все сторонние скрипты в папке js, кроме *custom*.js и сжимает их, записывая в файл js/vendors.min.js</li>
	<li><b title="gulp css-compress"><em>gulp css-compress</em></b>: сжатие собственных стилей в файл css/main.min.css</li>
	<li><b title="gulp rsync"><em>gulp rsync</em></b>: выгрузка проекта на рабочий сервер</li>
	<li><b title="gulp [default]"><em>gulp</em></b>: запуск группы тасков для слежения за изменениями css, js и php файлов</li>
</ul>

<h2>Структура рабочей папки src:</h2>

<ol>
	<li><b>js/_custom.js</b> - кастомный файл, где можно размещать собственные скрипты</li>
</ol>
