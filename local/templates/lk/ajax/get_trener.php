<?php
		error_reporting(E_ALL);
		ini_set('display_errors','On');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
try{
  $ret=array(
    "results"=>[
      ["id"=>1, "text"=>"Начните вводить фамилию...", 'disabled'=>true],
    ],
    "pagination"=>["more"=>false]  
  );
  if(!isset($_REQUEST['q']) or empty($_REQUEST['q']))throw new Exception();
  $q=addslashes(trim($_REQUEST['q']));
  $result=Aiplk::getUserSportsmeny($q, 10);
  if(empty($result) or !is_array($result))throw new Exception();
  $ret['results']=array();
  foreach($result as $row){
    if($curUser['ID']==$row['ID'])continue;
    //var_dump('<pre>',$vozrastGruppa,'</pre>');die();
    $ret['results'][]=array(
      'id'=>$row['ID'], 
      'text'=>Aiplk::getFIO($row)
    );
  }
  throw new Exception();
}catch(Exception $e){
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}
?>