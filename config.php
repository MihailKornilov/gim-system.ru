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

//id приложения, отвечающего за управление сайтом
define('MANAGE_APP_ID', 8);

define('PREFIX', LOCAL ? rand(1,99999) : 1);



function _br($v, $replace='<br>') {//вставка br в текст при нахождении enter
	if(!is_string($v))
		return $v;
	return str_replace("\n", $replace, $v);
}
function _num($v, $minus=0) {
	if(empty($v))
		return 0;
	if(is_array($v))
		return 0;
	if(is_string($v) && $minus && !preg_match(REGEXP_INTEGER, $v))
		return 0;
	if(is_string($v) && !$minus && !preg_match(REGEXP_NUMERIC, $v))
		return 0;

	return $v * 1;
}



