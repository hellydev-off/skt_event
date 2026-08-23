<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7, 11, 12)))die('Нет доступа.');
CModule::IncludeModule('iblock');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))throw new Exception('Нет доступа.');
  if(!empty($_REQUEST['prog_id']) and is_array($_REQUEST['prog_id'])){
    foreach($_REQUEST['prog_id'] as $prog_id){
      CIBlockElement::Delete(intval($prog_id));
    }
  }//else throw new Exception('Нет prog_id :(');
  ob_start();
  $id=$SOREVN_ID;
  require $_SERVER['DOCUMENT_ROOT'].'/include/sorevn/programmy_tpl.php';
  $ret['html']=ob_get_clean();
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));  
?>