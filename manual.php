<?php
require_once 'config.php';



die(GIM_MANUAL_html());




function GIM_MANUAL_html() {
	return
	'<!DOCTYPE html>'.
	'<html lang="en">'.
	'<head>'.
		'<meta charset="UTF-8">'.
		'<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'.
		'<title>GIM - documentation</title>'.
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
	return
	'<section class="doc-breadcrumbs">'.
		'<div class="doc-container">'.
			'<div class="doc-breadcrumbs__menu">'.
				'<a href="#" class="doc-breadcrumbs__link">Ремонт мобильной техники</a>'.
				'<span> » </span>'.
				'<a href="#" class="doc-breadcrumbs__link">Описание</a>'.
				'<span> » </span>'.
				'<span class="doc-breadcrumbs__current">Руководство пользователя</span>'.
			'</div>'.
		'</div>'.
	'</section>';
}
function GIM_MANUAL_menu() {
	$spisok = array(
		1 => 'Обзор приложения',
		2 => 'Клиенты',
		3 => 'Заявки',
		4 => 'Деньги',
		5 => 'Зарплата сотрудников',
		6 => 'Настройки'
	);

	$html = '';
	foreach($spisok as $id => $sp) {
		$active = $id == 1 ? ' doc-sidebar__link_active' : '';
		$html .=
		'<li class="doc-sidebar__item doc-sidebar__item_opened">'.
			'<a href="#" class="doc-sidebar__link'.$active.'">'.$sp.'</a>';

		if($id == 2)
			$html .=
			'<ul class="doc-sidebar__submenu">
				<li class="doc-sidebar__item"><a href="#" class="doc-sidebar__link">Список клиентов</a></li>
				<li class="doc-sidebar__item"><a href="#" class="doc-sidebar__link">Внесение нового клиента</a></li>
				<li class="doc-sidebar__item"><a href="#" class="doc-sidebar__link">Информация о клиенте</a></li>
				<li class="doc-sidebar__item"><a href="#" class="doc-sidebar__link">Редактирование клиента</a></li>
			</ul>';

		$html .= '</li>';
	}

	return
	'<section class="doc-info">
		<div class="doc-container">
			<div class="doc-info__wrapper">
				<div class="doc-sidebar">
					<ul class="doc-sidebar__menu">'.$html.'</ul>'.
				'</div>'.

				GIM_MANUAL_content().

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



















