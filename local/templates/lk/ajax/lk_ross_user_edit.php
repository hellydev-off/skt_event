<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');
$ret='';
try{
  if(empty($userId=intval($_REQUEST['userid'])))throw new Exception('Нет id :(');
  if(empty($_REQUEST['data'])){//форма
    require $_SERVER["DOCUMENT_ROOT"].'/include/lk2/lk_ross_user_edit.phtml';
  }else{//save

  }
}catch(Exception $e){
  $ret=$e->getMessage();
}
die($ret);