<?php
		error_reporting(E_ALL);
		ini_set('display_errors','On');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
try{
  $ret=array(
    "results"=>[
      ["id"=>1, "text"=>"Начните вводить фамилию...", 'disabled'=>true],
    ],
    "pagination"=>["more"=>false]  
  );
  if(!isset($_REQUEST['q']) or empty($_REQUEST['q']))throw new Exception();
  $q=addslashes(trim($_REQUEST['q']));
  $result=Aiplk::getUserSudi($q);
  if(empty($result) or !is_array($result))throw new Exception();
  $ret['results']=array();
  foreach($result as $row){
    $aReg=Aiplk::getRegionTitle($row);
    //v($row);
		$vozrast=Aiplk::getVozrast($row);
    $kateg=Aiplk::getKategoriiSudi(false, $row['UF_SUD_KAT']);
    $ret['results'][]=array(
      'id'=>$row['ID'], 
      'text'=>Aiplk::getFIO($row).' ('.$row['UF_GOROD'].', '.$vozrast.' '.Aiplk::vozrastTitle($vozrast).')', 
      'region_txt'=>$aReg['txt'], 
      'region_val'=>$aReg['val'],
      'kat_txt'=>$kateg['NAME'],
      'kat_val'=>$kateg['UF_XML_ID']
    );
  }
  throw new Exception();
}catch(Exception $e){
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}
?>