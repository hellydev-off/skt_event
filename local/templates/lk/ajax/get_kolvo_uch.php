<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7, 11, 12)))die('Нет доступа.');
CModule::IncludeModule('iblock');
$ret=array('err'=>'', 'html'=>0);
try{
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))throw new Exception('Нет доступа.');
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  $aVozrgruppa=$_REQUEST['vozrgruppa'];
  $discipl_id=addslashes($_REQUEST['discipl_id']);
  $a=Aiplk::getSportsmenyKolvo($SOREVN_ID, $discipl_id, $aVozrgruppa);
  $ret['html']=count($a);
  //var_dump('<pre>',$discipl_id,'</pre>');
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));  
?>