<?php
		error_reporting(E_ALL);
		ini_set('display_errors','On');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
try{
  $ret=array(
    "results"=>[
      ["id"=>1, "text"=>"Начните вводить название города...", 'disabled'=>true],
    ],
    "pagination"=>["more"=>false]  
  );
  if(!isset($_REQUEST['q']) or empty($_REQUEST['q']))throw new Exception();
  $q=addslashes(trim($_REQUEST['q']));
  $token="eb59e1c9f841ecbaaf23463afb003fa0e409a137";
  $secret="019957ec5be2a5d285aed82c1edcaf6ca3fe4d02";
  $dadata=new Dadata($token, $secret);
  $dadata->init();
  $fields = array("query"=>$q, "from_bound"=>["value"=>"city"], "to_bound"=>["value"=>"settlement"], "count"=>10);
  $result=$dadata->suggest("address", $fields);
  
  $dadata->close();
  if(empty($result['suggestions']) or !is_array($result['suggestions']))throw new Exception();
  $ret['results']=array();
  foreach($result['suggestions'] as $row){
    //v($row);die();
    $city=$row['data']['city'];
    if(empty($city))$city=$row['data']['settlement_with_type'];
    if(empty($city))continue;
    //$v=$row['data']['country'].'_'.$row['data']['region_with_type'].'_'.$city;
    $v=$row['data']['country'].'_'.$row['data']['region_iso_code'].'_'.$city;
    $v=str_replace('.', '-', $v);
    $v=str_replace(',', '-', $v);
    $v=str_replace(' ', '-', $v);
    $ret['results'][]=array("id"=>$v, "text"=>$row['data']['country'].', '.$row['data']['region_with_type'].', '.$city);
  }
  throw new Exception();
}catch(Exception $e){
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}
?>