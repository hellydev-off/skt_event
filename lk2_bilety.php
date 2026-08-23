<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(!in_array(11, $arGroups)and !in_array(10, $arGroups))die();
$APPLICATION->SetTitle('Билеты');
?>
<div class="h1_cont">
  <h1>Билеты</h1>
  <div>&nbsp;</div>  
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>