<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Протоколы");
$APPLICATION->SetPageProperty("title", "Протоколы");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
if(!CSite::InGroup(array(7,1)))die('Нет доступа.');
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>