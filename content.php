<?php





function GIM_html() {
	return
	'<!DOCTYPE html>'.
	'<html lang="en">'.

	'<head>'.
		'<meta charset="UTF-8">'.
		'<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'.
		'<title>GIM-system</title>'.
		'<meta name="keywords" content="text, test">'.
		'<meta name="description" content="very long text description">'.
		'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous"/>'.
		'<link rel="stylesheet" href="css/style.css?'.PREFIX.'">'.
		'<link rel="stylesheet" href="css/media.css?'.PREFIX.'">'.
	'</head>'.

	'<body>'.

		GIM_menu().
		GIM_about().
		GIM_services().
		GIM_why().
		GIM_faq().
		GIM_contacts().
		GIM_footer().

		'<script src="js/custom.js?'.PREFIX.'"></script>'.
	'</body>'.
	'</html>';
}


function GIM_menu() {
	return
	'<header class="header">
		<div class="container">
			<div class="header__inner">
				<a href="#" class="header-logo"><img src="img/logo-v1.svg" alt="GIM-system"></a>
				<div class="navigation">
					<div class="navigation-mobile">
						<div></div>
						<div></div>
						<div></div>
					</div>
					<ul class="menu">
						<li class="menu__item"><a href="#" class="menu__link menu__link_current">Главная</a></li>
						<li class="menu__item"><a href="#" class="menu__link">О программе</a></li>
						<li class="menu__item"><a href="#" class="menu__link">Цены</a></li>
						<li class="menu__item"><a href="#" class="menu__link">Конструктор</a></li>
						<li class="menu__item"><a href="#" class="menu__link">Контакты</a></li>
						<li class="menu__item"><a href="https://fast-bpm.ru/app" class="menu__link" target="blank"><b>APP</b></a></li>
					</ul>
				</div>
				<a href="#" class="btn header-login">вход</a>
			</div>
		</div>
	</header>';
}
function GIM_about() {
	return
	'<section class="cta">
		<div class="container">
			<div class="cta__text">
				<h1 class="cta__title">Global Intelligent Management - Система глобального интеллектуального управления.</h1>
				<p class="cta__description">Система управления малым бизнесом, позволяющая вести учёт входящих данных,
					контролировать выполнение задач, поставленные сотрудникам, просматривать статистику,
					получать уведомления о работе за разные периоды.</p>
			</div>
		</div>
	</section>';
}
function GIM_services() {
	$sql = "SELECT *
			FROM `_spisok`
			WHERE `dialog_id`=1321
			  AND `num_1`
			ORDER BY `sort`
			LIMIT 6";
	$arr = query_arr($sql);

	$send = '';
	foreach($arr as $r) {
		$href = $r['num_2'] ? ' href="/manual.php?app='.$r['num_2'].'"' : '';
		$send .=
			'<div class="services__items-single">'.
				'<a'.$href.' class="services-item">'.
					'<div class="services-item__top">'.
						'<div class="services-item__icon"><img src="img/service-icon.svg" alt="SN"></div>'.
						'<div class="services-item__title">'.$r['txt_1'].'</div>'.
					'</div>'.
					'<div class="services-item__description">'._br($r['txt_2']).'</div>'.
				'</a>'.
			'</div>';
	}
	return
	'<section class="services">
		<div class="container">
			<div class="title">'.
				'<span></span>'.
				'<h2>виды деятельности</h2>'.
				'<span></span></div>
			<div class="services__items">'.$send.'</div>
		</div>
	</section>';
}
function GIM_why() {
	return
	'<section class="why">
		<div class="container">
			<div class="title"><span></span>
				<h2>почему мы?</h2><span></span></div>
			<div class="why__text">
				<p>Система управления малым бизнесом, позволяющая вести учёт входящих данных,
					контролировать выполнение задач, поставленные сотрудникам, просматривать
					статистику, получать уведомления о работе за разные периоды.</p>
				<p>Система управления малым бизнесом, позволяющая вести учёт входящих данных,
					контролировать выполнение задач, поставленные сотрудникам, просматривать
					статистику, получать уведомления о работе за разные периоды.</p>
			</div>
		</div>
	</section>';
}
function GIM_faq() {
	return
	'<section class="faqs">
		<div class="container">
			<div class="title"><span></span>
				<h2>часто задаваемые вопросы</h2><span></span></div>
			<div class="faqs__items">
				<div class="faqs-item faqs-item_opened">
					<div class="faqs-item__qustion">
						<div class="faqs-item__title">что такое Global Intelligent Management ?</div>
						<div class="faqs-item__btn js-faqs">-</div>
					</div>
					<div class="faqs-item__answer">Система управления малым бизнесом, позволяющая вести учёт входящих данных,
						контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
					</div>
				</div>
				<div class="faqs-item">
					<div class="faqs-item__qustion">
						<div class="faqs-item__title">что такое Global Intelligent Management ?</div>
						<div class="faqs-item__btn js-faqs">+</div>
					</div>
					<div class="faqs-item__answer">Система управления малым бизнесом, позволяющая вести учёт входящих данных,
						контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
					</div>
				</div>
				<div class="faqs-item">
					<div class="faqs-item__qustion">
						<div class="faqs-item__title">что такое Global Intelligent Management ?</div>
						<div class="faqs-item__btn js-faqs">+</div>
					</div>
					<div class="faqs-item__answer">Система управления малым бизнесом, позволяющая вести учёт входящих данных,
						контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
					</div>
				</div>
				<div class="faqs-item">
					<div class="faqs-item__qustion">
						<div class="faqs-item__title">что такое Global Intelligent Management ?</div>
						<div class="faqs-item__btn js-faqs">+</div>
					</div>
					<div class="faqs-item__answer">Система управления малым бизнесом, позволяющая вести учёт входящих данных,
						контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
						Система управления малым бизнесом, позволяющая вести учёт входящих данных, контролировать выполнение задач,
						поставленные сотрудникам, просматривать статистику, получать уведомления о работе за разные периоды.
					</div>
				</div>
			</div>
		</div>
	</section>';
}
function GIM_contacts() {
	return
	'<section class="contacts">
		<div class="container">
			<div class="title"><span></span>
				<h2>Контакты</h2><span></span></div>
			<div class="contacts__items">
				<div class="contacts-info">
					<div class="contacts-info__title">наши контакты</div>
					<div class="contacts-info__text"><span>тел.:</span> +79851246547</div>
					<div class="contacts-info__text"><span>эл.почта:</span> admin@admin.com</div>
					<div class="contacts-info__text"><span>адрес: </span>Россия, г. Москва, простпект ленина 56, офис 14</div>
				</div>
				<div class="contacts-form">
					<div class="contacts-form__title">остались вопросы?</div>
					<form method="get" class="contacts-form__form">
						<input type="text" name="name" id="name" class="inp-contacts" placeholder="ваше имя" required>
						<input type="email" name="email" id="email" class="inp-contacts" placeholder="ваша почта" required>
						<textarea name="message" id="message" placeholder="ваш вопрос" class="txt-contacts" required></textarea>
						<button class="btn btn-subtim" type="submit">задать вопрос</button>
					</form>
				</div>
			</div>
		</div>
	</section>';
}

function GIM_footer() {
	return
	'<footer class="footer">
		<div class="container">
			<div class="footer__inner">
				<a href="#" class="header-logo"><img src="img/logo-v1.svg" alt="GIM-system"></a>
				<div class="navigation">
					<ul class="menu">
						<li class="menu__item"><a href="#" class="menu__link menu__link_current">Главная</a></li>
						<li class="menu__item"><a href="#" class="menu__link">О программе</a></li>
						<li class="menu__item"><a href="#" class="menu__link">Цены</a></li>
						<li class="menu__item"><a href="#" class="menu__link">Конструктор</a></li>
						<li class="menu__item"><a href="#" class="menu__link">Контакты</a></li>
					</ul>
			</div>
			<div class="socials">'.
			'<a href="https://vk.com/gimsys" target="_blank" class="socials-icon"><i class="fab fa-vk"></i></a>'.
//			'<a href="#" target="_blank" class="socials-icon"><i class="fab fa-facebook-f"></i></a>'.
			'</div>
			</div>
		</div>
	</footer>
	<div class="copyright">copyright 2019</div>';
}



