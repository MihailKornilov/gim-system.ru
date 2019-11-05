<?php
setlocale(LC_ALL, 'ru_RU.UTF-8');
setlocale(LC_NUMERIC, 'en_US');

define('DEBUG', false);
define('GLOBAL_DIR', dirname(__FILE__));
define('DOMAIN', $_SERVER['SERVER_NAME']);

require_once GLOBAL_DIR.'/syncro.php';
require_once GLOBAL_DIR.'/inc/mysql.php';

//id приложения, отвечающего за управление сайтом
define('MANAGE_APP_ID', 8);

define('PREFIX', LOCAL ? rand(1,99999) : 0);



function _br($v, $replace='<br>') {//вставка br в текст при нахождении enter
	if(!is_string($v))
		return $v;
	return str_replace("\n", $replace, $v);
}



