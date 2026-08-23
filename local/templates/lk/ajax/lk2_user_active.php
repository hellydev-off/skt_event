<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
try{
  if(Aiplk::getStartPage()!='lk_region')new Exception('Нет доступа.');
  if(empty($id=intval($_REQUEST['id'])))throw new Exception('Нет ID пользователя :(');
  if(empty($act=addslashes($_REQUEST['act'])))throw new Exception('Нет act :(');
  $ret=false;
  if($act=='confirm')$ret=8;//одобрен
  if($act=='denied')$ret=9;//не одобрен
  $user = new CUser;
  $user->Update($id, ["UF_DOPUSK"=>$ret]);
}catch(Exception $e){
  die($e->getMessage());
} 
die('ok');
?>