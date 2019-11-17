<?php
require_once 'config.php';



die(GIM_MANUAL_html());






function GIM_MANUAL_html() {
	define('GIM_APP', _num(@$_GET['app']));
	define('GIM_PAGE', GIM_MANUAL_pageIdGet());

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
				'<a href="/" class="header-logo"><img src="img/logo-v1.svg" alt="GIM"></a>'.
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
function GIM_MANUAL_pageIdGet() {//получение текущей ID страницы
	if($page_id = _num(@$_GET['page'])) {
		$sql = "SELECT COUNT(*)
				FROM `_spisok`
				WHERE `app_id`=".GIM_APP."
				  AND `dialog_id`=121
				  AND `id`=".$page_id;
		if(query_value($sql))
			return $page_id;
		return 0;
	}

	//страница по умолчанию
	$sql = "SELECT `id`
			FROM `_spisok`
			WHERE `app_id`=".GIM_APP."
			  AND `dialog_id`=121
			  AND `num_1`
			LIMIT 1";
	return _num(query_value($sql));
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
			  AND `num_3`
			ORDER BY `parent_id`,`sort`";
	if(!$MP = query_arr($sql))
		return GIM_MANUAL_appFail('Руководство не создано.');

	$MP = _arrChild($MP);

	$html = '';
	foreach($MP as $id => $sp) {
		$html .=
		'<li class="doc-sidebar__item doc-sidebar__item_opened">'.
			'<a href="manual.php?app='.GIM_APP.'&page='.$id.'" class="doc-sidebar__link'.GIM_MANUAL_menuActive($sp).'">'.$sp['txt_1'].'</a>'.
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
function GIM_MANUAL_menuActive($sp) {//установка активности страницы
	if(GIM_PAGE == $sp['id'])
		return ' doc-sidebar__link_active';
	return '';
}
function GIM_MANUAL_submenu($sp) {//вывод подразделов
	if(empty($sp['child']))
		return '';

	$send = '<ul class="doc-sidebar__submenu">';

	foreach($sp['child'] as $id => $sub) {
		$send .=
			'<li class="doc-sidebar__item">'.
				'<a href="manual.php?app='.GIM_APP.'&page='.$id.'" class="doc-sidebar__link'.GIM_MANUAL_menuActive($sub).'">'.$sub['txt_1'].'</a>'.
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
	$sql = "SELECT *
			FROM `_spisok`
			WHERE `id`=".GIM_PAGE."
			  AND `num_3`
			  AND !`deleted`";
	if(!$page = query_assoc($sql))
		return
		'<div class="doc-content">'.
			'<div class="doc-fail">'.
				'<div>Страницы не существует.</div>'.
			'</div>'.
		'</div>';

	$sql = "SELECT *
			FROM `_spisok`
			WHERE `dialog_id`=122
			  AND `num_2`=".GIM_PAGE."
			  AND `num_3`
			  AND !`deleted`
			ORDER BY `sort`";
	if(!$PRGF = query_arr($sql))
		return
		'<div class="doc-content">'.
			'<div class="doc-fail">'.
				'<div>Страница пустая.</div>'.
			'</div>'.
		'</div>';

	$send = '';
	foreach($PRGF as $r) {
		switch($r['num_1']) {
			//текст
			case 1:
				$send .= '<p>'._br($r['txt_1']).'</p>';
				break;
			//изображение
			case 2:
				if(!$image_id = _idsFirst($r['txt_2']))
					break;

				$sql = "SELECT *
						FROM `_image`
						WHERE `id`=".$image_id;
				if(!$img = query_assoc($sql))
					break;

				$send .=
					'<div class="image">'.
						_imageHtml($img, 670).
		($r['txt_3'] ? '<div class="podpis">'._br($r['txt_3']).'</div>' : '').//подпись
					'</div>';
				break;
			//видеоролик
			case 3:
				if(empty($r['txt_4']))
					break;
				$el['width'] = 600;
				$send .=
					'<div class="image">'.
						_elem76iframe($el, $r['txt_4']).
		($r['txt_3'] ? '<div class="podpis">'._br($r['txt_3']).'</div>' : '').
					'</div>';
				break;
		}
	}

	return
	'<div class="doc-content">'.
		'<div class="doc-content__title">'.$page['txt_1'].'</div>'.
		'<div class="doc-content__text">'.$send.'</div>'.
	'</div>';
}
















