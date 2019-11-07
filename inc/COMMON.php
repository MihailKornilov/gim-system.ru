<?php /* Функции, которые используются в приложении */

function _arrChild($arr) {//формирование массива с дочерними значеними по `parent_id`
	$send = array();
	foreach($arr as $id => $r)
		$send[$r['parent_id']][$id] = $r;
	return _arrChildOne($send);
}
function _arrChildOne($child, $parent_id=0) {//расстановка дочерних значений
	if(!$send = @$child[$parent_id])
		return array();

	foreach($send as $id => $r)
		$send[$id]['child'] = _arrChildOne($child, $id);

	return $send;
}

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

function _ids($ids, $return='ids') {//проверка корректности списка id, составленные через запятую
	/*
		$return - формат возвращаемого значения
				ids: id через запятую (по умолчанию)
				arr: массив (также если 1)
			  count: количество
		count_empty: количество, если = 0, то пустота
	*/
	if(!$ids)
		return _idsReturn(0, $return);

	$arr = array();

	foreach(explode(',', $ids) as $id) {
		if(!preg_match(REGEXP_INTEGER, $id))
			return _idsReturn(0, $return);
		if(!_num($id))
			continue;
		$arr[] = _num($id);
	}

	return _idsReturn(implode(',', $arr), $return);
}
function _idsReturn($v, $return) {//для _ids - формат возвращаемого результата
	switch($return) {
		default:
		case 'first'://первое значение
			$v = explode(',', $v);
			return _num($v[0]);
		case 'ids': return $v ? $v : 0;
		case 1:
		case 'arr': return $v ? explode(',', $v) : array();
		case 'count':return $v ? count(explode(',', $v)) : 0;
		case 'count_empty': return $v ? count(explode(',', $v)) : '';
	}
}
function _idsGet($arr, $i='id') {//возвращение из массива списка id через запятую
/*
	key: сборка id по ключу
*/
	$ids = array();
	foreach($arr as $id => $r) {
		if($i == 'key') {
			$ids[] = $id;
			continue;
		}
		if(empty($r[$i]))
			continue;
		if(is_array($r[$i]))
			continue;
		$ids[] = $r[$i];
	}
	return empty($ids) ? 0 : implode(',', array_unique($ids));
}
function _idsAss($v) {//получение списка id вида: $v[25] = 1; - выбранный список
	$send = array();

	if(empty($v))
		return $send;

	$arr = is_array($v) ? $v : _ids($v, 'arr');

	foreach($arr as $id)
		$send[$id] = 1;

	return $send;
}
function _idsFirst($v) {//первое значение последовательного массива (или идентификаторов через запятую)
	if(empty($v))
		return 0;
	if(!is_array($v))
		$v = _ids($v, 'arr');
	if(!isset($v[0]))
		return 0;

	return _num($v[0]);
}
function _idsLast($v) {//последнее значение последовательного массива (или идентификаторов через запятую)
	if(empty($v))
		return 0;

	if(!is_array($v))
		$v = _ids($v, 1);

	$c = count($v);

	return _num($v[$c - 1]);
}




function _imageServerCache() {//кеширование серверов изображений
	$key = 'IMG_SERVER';
	if($arr = _cache_get($key, 1))
		return $arr;

	$sql = "SELECT `id`,`path` FROM `_image_server`";
	return _cache_set($key, query_ass($sql), 1);
}
function _imageServer($v) {//получение сервера (пути) для изображнения
/*
	если $v - число, получение имени пути
	если $v - текст, это сам путь и получение id пути. Если нет, то создание
*/
	if(empty($v))
		return '';

	$SRV = _imageServerCache();

	//получение id пути
	if($server_id = _num($v)) {
		if(empty($SRV[$server_id]))
			return '';

		return $SRV[$server_id];
	}

	foreach($SRV as $id => $path)
		if($v == $path)
			return $id;

	//внесение в базу нового пути
	$sql = "INSERT INTO `_image_server` (
				`path`,
				`user_id_add`
			) VALUES (
				'".addslashes($v)."',
				"._num(@USER_ID)."
			)";
	$insert_id = query_id($sql);

	_cache_clear('IMG_SERVER', 1);

	return $insert_id;
}
function _imageNo($width=80, $cr=false) {//картинка, если изображнеия нет
	return
	'<img src="'.APP_HTML.'/img/nofoto-s.gif"'.
		' width="'.$width.'"'.
 ($cr ? ' class="br1000"' : '').//круглое фото
	' />';
}
function _imageHtml($r, $width=80, $h=0, $cr=false, $click=true) {//получение картинки в html-формате
	if(empty($r))
		return _imageNo($width, $cr);
	if(!is_array($r))
		return _imageNo($width, $cr);
	if(empty($r['id']))
		return _imageNo($width, $cr);

	$width = $width ? $width : 80;

	$st = $width > 80 ? 'max' : 80;
	$width = $width > $r['max_x'] ? $r['max_x'] : $width;
	if($h) {
		$s = _imageResize($r['max_x'], $r['max_y'], $width, $width);
		$width = $s['x'];
		$h = $s['y'];
	}

	$cls = array();
	if($click)
		$cls[] = 'image-open';
	if($cr)
		$cls[] = 'br1000';

	return
		'<img src="'._imageServer($r['server_id']).$r[$st.'_name'].'"'.
			' width="'.$width.'"'.
	  ($h ? ' height= "'.$h.'"' : '').
	($cls ? ' class="'.implode(' ', $cls).'"'.
			' val="'.(empty($r['ids']) ? $r['id'] : $r['ids']).'"'
  : '').

		' />';
}
function _imageResize($x_cur, $y_cur, $x_new, $y_new) {//изменение размера изображения с сохранением пропорций
	$x = $x_new;
	$y = $y_new;
	// если ширина больше или равна высоте
	if ($x_cur >= $y_cur) {
		if ($x > $x_cur) { $x = $x_cur; } // если новая ширина больше, чем исходная, то X остаётся исходным
		$y = round($y_cur / $x_cur * $x);
		if ($y > $y_new) { // если новая высота в итоге осталась меньше исходной, то подравнивание по Y
			$y = $y_new;
			$x = round($x_cur / $y_cur * $y);
		}
	}

	// если высота больше ширины
	if ($y_cur > $x_cur) {
		if ($y > $y_cur) { $y = $y_cur; } // если новая высота больше, чем исходная, то Y остаётся исходным
		$x = round($x_cur / $y_cur * $y);
		if ($x > $x_new) { // если новая ширина в итоге осталась меньше исходной, то подравнивание по X
			$x = $x_new;
			$y = round($y_cur / $x_cur * $x);
		}
	}

	return array(
		'x' => $x,
		'y' => $y
	);
}










function _cache($v=array()) {
	if(!defined('CACHE_DEFINE')) {
		define('CACHE_USE', true);//включение кеша
		define('CACHE_TTL', 86400);//время в секундах, которое хранит кеш
		define('CACHE_DEFINE', true);
	}

	//действие:
	//	get - считывание данных из кеша (по умолчанию)
	//	set - занесение данных в кеш
	//	clear - очистка кеша
	$action = empty($v['action']) ? 'get' : $v['action'];

	//глобальное значение: доступно для всех приложений
	//если внутреннее, то к ключу будет прибавляться префикс
	$global = !empty($v['global']);

	if(empty($v['key']))
		die('Отсутствует ключ кеша.');

	$key = $v['key'];

	if(is_array($key))
		die('Ключ кеша не может быть массивом.');

	$key = '__'.($global || !_num(@APP_ID) ? 'GLOBAL' : 'APP'.APP_ID).'_'.$key;

	switch($action) {
		case 'get': return CACHE_USE ? apcu_fetch($key) : false;
		case 'set':
//			if(!isset($v['data']))
//				die('Отсутствуют данные для внесения в кеш. Key: '.$key);

			if(CACHE_USE)
				apcu_store($key, $v['data'], CACHE_TTL);

			return $v['data'];
		case 'isset': return CACHE_USE ? apcu_exists($key) : false;
		case 'clear':
			if(CACHE_USE)
				apcu_delete($key);
			return true;
		default: die('Неизвестное действие кеша.');
	}
}
function _cache_get($key, $global=0) {//получение значений кеша
	return _cache(array(
		'action' => 'get',
		'key' => $key,
		'global' => $global
	));
}
function _cache_set($key, $data, $global=0) {//запись значений в кеш
	return _cache(array(
		'action' => 'set',
		'key' => $key,
		'data' => $data,
		'global' => $global
	));
}
function _cache_isset($key, $global=0) {//проверка, производилась ли запись в кеш
	return _cache(array(
		'action' => 'isset',
		'key' => $key,
		'global' => $global
	));
}
function _cache_clear($key, $global=0) {//очистка кеша
	if($key == 'all') {
		if(CACHE_USE)
			apcu_clear_cache();
		return true;
	}

	return _cache(array(
		'action' => 'clear',
		'key' => $key,
		'global' => $global
	));
}
function _cache_content() {//содержание кеша в диалоге [84] (подключаемая функция [12])
	if(!CACHE_USE)
		$send = 'Кеш отключен.';
	elseif(!$name = @$_COOKIE['cache_content_name'])
			$send = 'Отсутствует имя кеша.';
		else {
			if(!apcu_exists($name))
				$send = '<b>'.$name.'</b>: кеш не сохранён.';
			else {
				if(!$arr = apcu_fetch($name))
					$send = '<b>'.$name.'</b>: кеш пуст.';
				else
					$send =
						'<div class="fs15 b mb10">'.$name.'</div>'.
						_pr($arr);
			}
		}
	return
	'<div style="height:700px;width:560px;overflow-y:scroll;word-wrap:break-word" class="bg-fff bor-e8 pad10">'.
		$send.
	'</div>';
}



