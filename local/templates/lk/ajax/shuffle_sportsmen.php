<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7)))die('Нет доступа...');
CModule::IncludeModule('iblock');
if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))die('Нет id мероприятия :(');
$el=new CIBlockElement;
$aDisc=Aiplk::getDisciplina();
$aSportsmeny=Aiplk::getSportsmeny($ID_SOREVN);
$aCurrentDiscipl=array();
foreach($aDisc as $_gr){
  foreach($aSportsmeny as $_item){
    if(in_array($_gr['UF_XML_ID'], $_item['PROPERTIES']['DISCIPLINY']['VALUE'])){
      $aCurrentDiscipl[$_gr['UF_XML_ID']][]=$_item['ID'];
    }
  }
}
foreach($aCurrentDiscipl as $k=>$v){
  shuffle($aCurrentDiscipl[$k]);
}
foreach($aSportsmeny as $aUser){
  $aUserSort=array();
  foreach($aCurrentDiscipl as $discId=>$aUserId){
    $k=array_search($aUser['ID'], $aUserId);
    if($k!==false){
      $aUserSort[$discId]=$k+1;
    }
  }
  $aUserSort=json_encode($aUserSort, JSON_UNESCAPED_UNICODE);
  $el->SetPropertyValuesEx($aUser['ID'], 6, ['SORT'=>$aUserSort]);
}
die();
?>