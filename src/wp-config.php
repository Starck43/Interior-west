<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'your_db_name');
/** Имя пользователя MySQL */
define('DB_USER', 'your_username');
/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'your_password');
/** Имя сервера MySQL (обычно не изменяется) */
define('DB_HOST', 'localhost');
/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');
/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@-*/
/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать разные префиксы.
 * Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 *
 * В принципе этот префикс можно не трогать, все будет работать. 
 * Указанный в переменной $table_prefix будет использоваться для всех создаваемых таблиц.
 */
$table_prefix  = 'wp_';
/**
 *
 *
 * Ключи аутентификации
 *
 * Также обязательно нужно изменить ключи аутентификации. Эти ключи используются в разных местах кода WordPress для защиты от взлома.
 * Чтобы не сочинять ключи самому их можно быстро генерировать по следующей ссылке: https://api.wordpress.org/secret-key/1.1/salt/
 */
 
define('AUTH_KEY',         'впишите сюда уникальную фразу');
define('SECURE_AUTH_KEY',  'впишите сюда уникальную фразу');
define('LOGGED_IN_KEY',    'впишите сюда уникальную фразу');
define('NONCE_KEY',        'впишите сюда уникальную фразу');
define('AUTH_SALT',        'впишите сюда уникальную фразу');
define('SECURE_AUTH_SALT', 'впишите сюда уникальную фразу');
define('LOGGED_IN_SALT',   'впишите сюда уникальную фразу');
define('NONCE_SALT',       'впишите сюда уникальную фразу');

/**
 * Для разработчиков: Режим отладки WordPress. В обычном режиме false
 *
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. */
/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');