<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,10,11)))die('Нет доступа.');
CModule::IncludeModule('iblock');
if(empty($id=intval($_REQUEST['sid'])))die('Ошибка при удалении - нет ID :(');
if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($id))die('Нет доступа.');
//if(!CSite::InGroup(array(9)))die('Нет прав');
$el=new CIBlockElement;
$el->Update($id, array('ACTIVE'=>'N'));
    //Обновляем кол-во в программе
    //Aiplk::updateProgramKolvo($aProps, $SOREVN_ID);
    //
die();
?>