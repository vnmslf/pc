<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
CJSCore::Init(array('jquery3'));
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/main.min.js');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/global.min.css');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/header.min.css');
$now_url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
$mini_url = explode('?', $_SERVER['REQUEST_URI']);
$mini_url = $mini_url[0];?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta charset="utf-8">
	<link rel="alternate" hreflang="x-default" href="<?=$now_url?>" />
	<?$APPLICATION->ShowHead();?>
	<link rel="apple-touch-icon" sizes="57x57" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?=SITE_TEMPLATE_PATH?>/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?=SITE_TEMPLATE_PATH?>/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?=SITE_TEMPLATE_PATH?>/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<meta name="yandex-verification" content="YANDEX VERIFICATION ID" />
	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<header>
		<div class="container">
			<div class="header__top-bar">
				<div class="left">
					<a href="https://t.me/+79034053366" target="_blank">
						<?=Tools\ViewHelper::getSvg('telegram')?>
					</a>
					<a href="whatsapp://send?phone=+79034053366&text=Здравствуйте!\nУ меня есть вопросы по продукции с сайта https://pro-components.ru/" target="_blank">
						<?=Tools\ViewHelper::getSvg('whatsapp')?>
					</a>
				</div>
				<div class="right">
					<a href="/contacts/">
						<?=Tools\ViewHelper::getSvg('time')?>
						<span>8:00 &mdash; 21:00</span>
					</a>
				</div>
			</div>
			<div class="header__middle">
				<div class="left">
					<a href="/">
						<?=Tools\ViewHelper::getSvg('logo');?>
					</a>
				</div>
				<div class="center">
<?$APPLICATION->IncludeFile(
	SITE_TEMPLATE_PATH.'/inc/header_menu.php',
	Array(), 
	Array(
		'MODE' => 'html',
		'NAME' => 'Редактирование включаемого меню',
		'TEMPLATE'  => ''
	)
);?>
				</div>
				<div class="right">
					<div class="contacts">
						<div class="contacts__block">
							<a href="mailto:hello@pro-components.ru">
								<?=Tools\ViewHelper::getSvg('email')?>
								<span>hello@pro-components.ru</span>
							</a>
						</div>
						<div class="contacts__block">
							<a href="tel:+79034053366">
								<?=Tools\ViewHelper::getSvg('phone')?>
								<span>+7 (903) 405-33-66</span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="management">
				<div class="management__menu-button catalog-button">
					<?=Tools\ViewHelper::getSvg('catalog')?>
					<span>Каталог</span>
				</div>
				<div class="menu">
<?$APPLICATION->IncludeFile(
	SITE_TEMPLATE_PATH.'/inc/header_menu.php',
	Array(), 
	Array(
		'MODE' => 'html',
		'NAME' => 'Редактирование включаемого меню',
		'TEMPLATE'  => ''
	)
);?>
				</div>
				<div class="management__menu-button order-button">
					<?=Tools\ViewHelper::getSvg('send-order')?>
					<span>Оставить заявку</span>
				</div>
			</div>
		</div>
	</header>