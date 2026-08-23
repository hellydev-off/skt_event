<?php
		// error_reporting(E_ALL);
		// ini_set('display_errors','On');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');

$curUser=Aiplk::getUser($GLOBALS['USER']->getID());

try{
  $ret=array(
    "results"=>[
      ["id"=>1, "text"=>"Начните вводить фамилию...", 'disabled'=>true],
    ],
    "pagination"=>["more"=>false]  
  );
  if(!isset($_REQUEST['q']) or empty($_REQUEST['q']))throw new Exception();
  if(!empty($_REQUEST['VGRUPPA']))$vgruppa=addslashes($_REQUEST['VGRUPPA']);else $vgruppa=false;
  $q=addslashes(trim($_REQUEST['q']));

  if(!CSite::InGroup(array(11))){
    $result=Aiplk::getUserSportsmeny($q, 8, $curUser['UF_REGION_SPR']);//только регион текущего юзера
  }else{
    $result=Aiplk::getUserSportsmeny($q, 8, false);//только регион текущего юзера
  }

  if(empty($result) or !is_array($result))throw new Exception();
  $ret['results']=array();
  foreach($result as $row){
    $aReg=Aiplk::getRegionTitle($row);
    $vozrastGruppa=Aiplk::getVozrastGruppa($row);
		$vozrast=Aiplk::getVozrast($row);
    if($vgruppa and $vozrastGruppa[2]['UF_XML_ID']!=$vgruppa)continue;
    $ret['results'][]=array(
      'id'=>$row['ID'], 
      'text'=>Aiplk::getFIO($row).' ('.$row['UF_GOROD'].', '.$vozrast.' '.Aiplk::vozrastTitle($vozrast).')', 
      'region_txt'=>$aReg['txt'], 
      'region_val'=>$aReg['val'], 
      'vozrast_gruppa_val'=>$vozrastGruppa[2]['UF_XML_ID'],
      'vozrast_gruppa_txt'=>$vozrastGruppa[2]['NAME'],
      'data_rozhd'=>ConvertDateTime($row['PERSONAL_BIRTHDAY'], "YYYY-MM-DD", "ru")
    );
  }
  throw new Exception();
}catch(Exception $e){
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}
?>