<?php
require_once 'config.php';



die(GIM_MANUAL_html());


function _arrChild($ARR) {//формирование массива с дочерними значеними по `parent_id`
	$send = array();
	foreach($ARR as $id => $r)
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




function GIM_MANUAL_html() {
	define('GIM_APP', _num(@$_GET['app']));

	return
	'<!DOCTYPE html>'.
	'<html lang="en">'.
	'<head>'.
		'<meta charset="UTF-8">'.
		'<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'.
		'<title>GIM - manual</title>'.
		'<meta name="keywords" content="text, test">'.
		'<meta name="description" content="very long text description">'.
		'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous"/>'.
		'<link rel="stylesheet" href="css/style.css?'.PREFIX.'">'.
		'<link rel="stylesheet" href="css/media.css?'.PREFIX.'">'.
	'</head>'.
	'<body>'.

		GIM_MANUAL_header().
		GIM_MANUAL_path().
		GIM_MANUAL_menu().

		'<div class="copyright">copyright 2019</div>'.

		'<script src="js/custom.js?'.PREFIX.'"></script>'.
	'</body>'.
	'</html>';
}
function GIM_MANUAL_header() {//шапка
	return
	'<header class="header">'.
		'<div class="doc-container">'.
			'<div class="header__inner">'.
				'<a href="#" class="header-logo"><img src="img/logo-v1.svg" alt="GIM"></a>'.
				'<div class="doc-header">'.
					'<div class="doc-header__title">руководство</div>'.
					'<form method="get" class="doc-header__search">'.
						'<button class="btn-doc-submit" type="submit"><i class="fas fa-search"></i></button>'.
						'<input type="search" name="search" id="search" class="inp-doc-search" placeholder="Поиск...">'.
					'</form>'.
				'</div>'.
				'<a href="#" class="btn header-login">вход</a>'.
			'</div>'.
		'</div>'.
	'</header>';
}
function GIM_MANUAL_path() {//путь
	$sql = "SELECT *
			FROM `_app`
			WHERE `id`=".GIM_APP;
	if(!$app = query_assoc($sql))
		return '';

	return
	'<section class="doc-breadcrumbs">'.
		'<div class="doc-container">'.
			'<div class="doc-breadcrumbs__menu">'.
				'<a href="#" class="doc-breadcrumbs__link">'.$app['name'].'</a>'.
				'<span> » </span>'.
				'<a href="#" class="doc-breadcrumbs__link">Описание</a>'.
				'<span> » </span>'.
				'<span class="doc-breadcrumbs__current">Руководство пользователя</span>'.
			'</div>'.
		'</div>'.
	'</section>';
}
function GIM_MANUAL_menu() {
	//получение данных о приложении
	$sql = "SELECT *
			FROM `_app`
			WHERE `id`=".GIM_APP;
	if(!$app = query_assoc($sql))
		return GIM_MANUAL_appFail('Приложение не найдено.');

	//получение списка страниц
	$sql = "SELECT *
			FROM `_spisok`
			WHERE `app_id`=".$app['id']."
			  AND `dialog_id`=121
			ORDER BY `parent_id`,`sort`";
	if(!$MP = query_arr($sql))
		return GIM_MANUAL_appFail('Руководство не создано.');

	$MP = _arrChild($MP);

	$n = 0;
	$html = '';
	foreach($MP as $id => $sp) {
		$active = !$n++ ? ' doc-sidebar__link_active' : '';
		$html .=
		'<li class="doc-sidebar__item doc-sidebar__item_opened">'.
			'<a href="#" class="doc-sidebar__link'.$active.'">'.$sp['txt_1'].'</a>'.
			GIM_MANUAL_submenu($sp).
		'</li>';
	}

	return
	'<section class="doc-info">'.
		'<div class="doc-container">'.
			'<div class="doc-info__wrapper">'.
				'<div class="doc-sidebar">'.
					'<ul class="doc-sidebar__menu">'.$html.'</ul>'.
				'</div>'.

				GIM_MANUAL_content().

			'</div>'.
		'</div>'.
	'</section>';
}
function GIM_MANUAL_submenu($sp) {//вывод подразделов
	if(empty($sp['child']))
		return '';

	$send = '<ul class="doc-sidebar__submenu">';

	foreach($sp['child'] as $sub) {
		$send .=
			'<li class="doc-sidebar__item">'.
				'<a href="#" class="doc-sidebar__link">'.$sub['txt_1'].'</a>'.
				GIM_MANUAL_submenu($sub).
			'</li>';
	}

	$send .= '</ul>';

	return $send;
}
function GIM_MANUAL_appFail($msg) {
	return
	'<section class="doc-info">'.
		'<div class="doc-container">'.
			'<div class="doc-fail">'.
				'<div>'.$msg.'</div>'.
			'</div>'.
		'</div>'.
	'</section>';
}
function GIM_MANUAL_content() {
	return
	'<div class="doc-content">'.
		'<div class="doc-content__title">Обзор приложения</div>'.
		'<div class="doc-content__text">'.
			'<p>Данное руководство содержит описание функционала приложения <span>Ремонт мобильной техники.</span></p>'.
			'<p>Корневые разделы расположены в порядке значимости, в подразделах расписаны все возможные функции приложения.</p>'.
			'<p>3."Черный список".Есть возможность добавления клиента в черный список (этот знак и есть'.
				'добавление клиента в черный список)- клиента мы добавляем в черный список, потому что'.
				'не хотим больше иметь дела с этим клиентом, т.к клиент постоянно названивает, либочто-то'.
				'не так сделали, из-за маленькой помарочки говорит, чтобы вы переделывали, хотя лучше'.
				'уже никак не сделать, в общем вы увидите когда надо клиента добавлять в черный список.</p>'.
			'<img src="img/doc-img-example.png" alt="img text">'.
		'</div>'.
	'</div>';
}



















