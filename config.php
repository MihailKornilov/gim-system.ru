<?php
setlocale(LC_ALL, 'ru_RU.UTF-8');
setlocale(LC_NUMERIC, 'en_US');

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);


define('DEBUG', false);
define('GLOBAL_DIR', dirname(__FILE__));
define('DOMAIN', $_SERVER['SERVER_NAME']);

require_once GLOBAL_DIR.'/syncro.php';
require_once GLOBAL_DIR.'/inc/regexp.php';
require_once GLOBAL_DIR.'/inc/mysql.php';
require_once GLOBAL_DIR.'/inc/COMMON.php';

//id приложения, отвечающего за управление сайтом
define('MANAGE_APP_ID', 8);

define('PREFIX', LOCAL ? rand(1,99999) : 2);






