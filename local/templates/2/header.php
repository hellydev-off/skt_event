<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Page\Asset;
$assets=\Bitrix\Main\Page\Asset::getInstance();
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Language" content="ru"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="format-detection" content="telephone=no">
    <title><?$APPLICATION->ShowTitle()?></title>
		<?$APPLICATION->ShowHead()?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
		<?
			$assets->addCss(SITE_TEMPLATE_PATH.'/js/jscrollpane/jscrollpane.css');
			$assets->addCss(SITE_TEMPLATE_PATH.'/js/form_template/form.css');
			$assets->addCss(SITE_TEMPLATE_PATH.'/fonts/icomoon/style.css?v=1');
			$assets->addCss(SITE_TEMPLATE_PATH.'/css/defaults.css');
			$assets->addCss(SITE_TEMPLATE_PATH.'/css/style.css?v=1');
			$assets->addCss(SITE_TEMPLATE_PATH.'/css/responsive.css?v=1');
		?>
<?
$assets->addJs(SITE_TEMPLATE_PATH.'/js/jquery-3.5.1.min.js');
$assets->addJs(SITE_TEMPLATE_PATH.'/js/jscrollpane/jscrollpane.min.js');
$assets->addJs(SITE_TEMPLATE_PATH.'/js/form_template/form.js');
$assets->addJs(SITE_TEMPLATE_PATH.'/js/main.js?v=1');
?>




</head>
<body>
<?$APPLICATION->ShowPanel();?>

<div class="wrapper">
	<div class="wrapper-top">
        <header>
            <div class="header-top">
                <div class="container">
                    <a href="/" class="header-logo">
                        <i class="icon-logo"></i>
                    </a>
                    <div class="header-account-btns">
                        <a class="header-account-btn" href="https://skt-event.com/lk.php">Войти</a>
                        <?/*<a class="header-account-btn" href="https://skt-event.com/lk.php">Регистрация</a>*/?>
                    </div>
                </div>
            </div>
        </header>
