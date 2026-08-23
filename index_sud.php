<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetPageProperty("title", "Общероссийская ФСОО \"Спортивное метание ножа\"");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
$APPLICATION->AddChainItem('Личный кабинет');
?><div class="item-list">
	<h1 class="block-title">Протоколы</h1>
	<div class="merop_list_cont">
		<div class="merop_item">
			<div class="h4">
				Чемпионат России
			</div>
			<div class="merop_daty">
				Даты проведения: 10.02.23 - 11.03.23
			</div>
			<div class="merop_daty">
				Место проведения: г. Краснодар
			</div>
 <br>
			<div class="merop_btn_cont">
 <a class="btn btn-primary btn-sm" href="#">Судейская коллегия</a> <a class="btn btn-primary btn-sm" href="#">Программа</a> <a class="btn btn-primary btn-sm" href="#">Регистрация</a> <a class="btn btn-primary btn-sm" href="#">Протоколы</a> <a class="btn btn-primary btn-sm" href="#">Отчеты</a> <a class="btn btn-primary btn-sm" href="#">Редактировать</a> <a class="btn btn-primary btn-sm" href="#">Удалить</a>
			</div>
		</div>
	</div>
</div>

</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>