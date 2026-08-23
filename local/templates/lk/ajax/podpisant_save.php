<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(!is_array($_REQUEST['data']))throw new Exception('Нет data :(');
  $aCurRegion=Aiplk::getCurRegion();
  if(empty($aCurRegion['UF_XML_ID']))throw new Exception('Не удалось определить регион пользователя :(');
  $aSorevn=Aiplk::getSorevn($SOREVN_ID);
  $aPodpByRegion=json_decode($aSorevn['PROPERTIES']['PODZASRANTY']['~VALUE'], true);
  if(!is_array($aPodpByRegion))$aPodpByRegion=array();
  $aPodpByRegion[$aCurRegion['UF_XML_ID']]=$_REQUEST['data'];
  $el=new CIBlockElement;
  $el->SetPropertyValuesEx($SOREVN_ID, 3, ['PODZASRANTY'=>json_encode($aPodpByRegion, JSON_UNESCAPED_UNICODE)]);
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));
?>